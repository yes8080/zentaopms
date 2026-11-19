<?php
$result = $this->extension->executeDB($extension, 'install');
if($result->result !== 'ok') throw new RuntimeException('Request intake schema upgrade failed.');
