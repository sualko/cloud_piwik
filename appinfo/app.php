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

$internal = OCP\Config::getAppValue ( 'piwik', 'internal' );

if ($internal === 'yes') {
   OCP\Util::addScript ( 'piwik', 'piwik');
}

$piwik = json_decode(OCP\Config::getAppValue ( 'piwik', 'piwik' ));
$url = parse_url($piwik->url,PHP_URL_HOST);

if($_SERVER['HTTP_HOST'] !== $url) {
   $policy = new OCP\AppFramework\Http\ContentSecurityPolicy ();
   $policy->addAllowedScriptDomain($url);
   $policy->addAllowedImageDomain($url);
   \OC::$server->getContentSecurityPolicyManager()->addDefaultPolicy($policy);
}

OCP\Util::addScript ( 'piwik', 'track' );

?>
