<?php
OCP\JSON::callCheck();

$result = OCP\Config::getAppValue('piwik', 'piwik');

OC_JSON::success(array('data'=>$result));
?>
