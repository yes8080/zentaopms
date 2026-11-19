<?php
public function create(object $bug, string $from = ''): int|false
{
    $extras = $this->app->getParams()['extras'] ?? '';
    parse_str(str_replace(',', '&', $extras), $params);
    if(!array_key_exists('riOperation', $params)) return parent::create($bug, $from);

    $this->app->loadLang('reqintake');
    try
    {
        if(!is_string($params['riOperation']) || $from !== '' || !empty($params['todoID']))
            throw new DomainException('linkTarget');

        return $this->loadModel('reqintake')->convertToNative(
            $params['riOperation'], 'bug', (int)$bug->product, fn() => parent::create($bug)
        );
    }
    catch(DomainException $error)
    {
        dao::$errors['title'][] = $this->lang->reqintake->errors[$error->getMessage()] ?? $this->lang->reqintake->invalid;
        return false;
    }
}
