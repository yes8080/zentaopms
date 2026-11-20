<?php
/* Inspect or migrate credentials for the installed MySQL application. */
if(PHP_SAPI !== 'cli') exit(1);
$mode = $argv[1] ?? '';
if(!in_array($mode, array('--check', '--apply'), true))
{
    fwrite(STDERR, "Usage: php migrate-provider-tokens.php --check|--apply\n");
    exit(2);
}

$root = dirname(__DIR__, 2);
chdir($root);
require_once './framework/router.class.php';
require_once './framework/control.class.php';
require_once './framework/model.class.php';
require_once './framework/helper.class.php';
require_once './module/common/model.php';
require_once './module/provider/model.php';

$db = null;
$transaction = false;
try
{
    $app = router::createApp('pms', $root, 'router');
    $db = $app->dbh;
    /* Upgrades from older releases can leave an archived pipeline table. Report it separately. */
    $oldTable = $app->config->db->prefix . 'pipeline';
    $hasArchive = $db->prepare("SELECT COUNT(*) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND COLUMN_NAME = 'token'");
    $hasArchive->execute(array($oldTable));
    if($oldTable !== 'ops_provider' && $hasArchive->fetchColumn())
    {
        $table = '`' . str_replace('`', '``', $oldTable) . '`';
        $count = (int)$db->query("SELECT COUNT(*) FROM $table WHERE token <> ''")->fetchColumn();
        if($count) printf("Historical pipeline records with credentials: %d. Review them separately and retire obsolete tokens after upgrade.\n", $count);
    }

    $apply = $mode === '--apply';
    if($apply)
    {
        $transaction = $db->beginTransaction();
        if(!$transaction) throw new RuntimeException();
    }

    $sql = 'SELECT id, type, url, token FROM ' . TABLE_PROVIDER . " WHERE token <> '' ORDER BY id";
    $rows = $db->query($sql . ($apply ? ' FOR UPDATE' : ''))->fetchAll(PDO::FETCH_OBJ);
    $update = $db->prepare('UPDATE ' . TABLE_PROVIDER . ' SET token = ? WHERE id = ?');
    $width = $db->query("SELECT CHARACTER_MAXIMUM_LENGTH FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'ops_provider' AND COLUMN_NAME = 'token'")->fetchColumn();
    $sealed = $legacy = 0;
    foreach($rows as $row)
    {
        if(preg_match('/^gcm[0-9]+:/', $row->token))
        {
            if(providerModel::decryptToken($row) === '') throw new RuntimeException();
            $sealed++;
            continue;
        }

        $plain = $row->type === 'Jenkins' ? base64_decode($row->token, true) : $row->token;
        if($plain === false || ($row->type === 'Jenkins' && !str_contains($plain, ':'))) throw new RuntimeException();
        $encrypted = providerModel::encryptToken($row, $plain);
        if(strlen($encrypted) > (int)$width)
        {
            fwrite(STDERR, "Run db/secure-provider-credentials.sql to widen the credential column.\n");
            throw new RuntimeException();
        }
        if($apply && (!$update->execute(array($encrypted, $row->id)) || $update->rowCount() !== 1)) throw new RuntimeException();
        $legacy++;
    }

    if($apply && !$db->commit()) throw new RuntimeException();
    $transaction = false;
    printf("Verified existing envelopes: %d. %s: %d.\n", $sealed, $apply ? 'Migrated credentials' : 'Pending credentials', $legacy);
}
catch(Throwable $e)
{
    if($transaction) $db->rollBack();
    fwrite(STDERR, "Migration incomplete. Check the installed database, credential column, integration key and existing envelopes. No credentials were printed.\n");
    exit(1);
}
