<?php 

 /**
  * owncloud_piwik
  * 
  * Copyright (c) 2015 Klaus Herberth <klaus@jsxc.org> <br>
  * Released under the MIT license
  * 
  * @author Klaus Herberth <klaus@jsxc.org>
  * @license MIT
  */

OCP\App::registerAdmin ( 'piwik', 'settings-admin' );

$internal = OCP\Config::getAppValue ( 'piwik', 'internal','no' );

if ($internal === 'yes') {
   OCP\Util::addScript ( 'piwik', 'piwik');
}

OCP\Util::addScript ( 'piwik', 'track' );

?>
