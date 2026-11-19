<?php
$config->message->objectTypes['aitask'] = array('finished', 'failed');
$config->message->available['mail']['aitask']     = $config->message->objectTypes['aitask'];
$config->message->available['webhook']['aitask']  = $config->message->objectTypes['aitask'];
$config->message->available['message']['aitask']  = $config->message->objectTypes['aitask'];
$config->message->available['sms']['aitask']      = $config->message->objectTypes['aitask'];
$config->message->available['xuanxuan']['aitask'] = $config->message->objectTypes['aitask'];
