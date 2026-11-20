<?php
/* Print the repository-specific GitLab token for a manually registered hook. */
if(PHP_SAPI !== 'cli') exit(1);
$id = filter_var($argv[1] ?? '', FILTER_VALIDATE_INT, array('options' => array('min_range' => 1)));
if($id === false)
{
    fwrite(STDERR, "Usage: php gitlab-repo-hook-token.php <repository-id>\n");
    exit(1);
}

$root = dirname(__DIR__, 2);
require $root . '/framework/model.class.php';
require $root . '/module/common/model.php';
require $root . '/module/gitlab/model.php';
$token = gitlabModel::webhookToken('repo', $id);
if($token === '')
{
    fwrite(STDERR, "A valid integration key is required.\n");
    exit(1);
}
fwrite(STDOUT, $token . PHP_EOL);
