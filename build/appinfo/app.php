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

if(class_exists('\\OCP\\AppFramework\\Http\\ContentSecurityPolicy')) {
   $piwik = json_decode(OCP\Config::getAppValue('piwik', 'piwik'));
   $url = parse_url($piwik->url, PHP_URL_HOST);

   if (array_key_exists('HTTP_HOST', $_SERVER) && $_SERVER['HTTP_HOST'] !== $url) {
      $policy = new OCP\AppFramework\Http\ContentSecurityPolicy ();
      $policy->addAllowedScriptDomain($url);
      $policy->addAllowedImageDomain($url);
      \OC::$server->getContentSecurityPolicyManager()->addDefaultPolicy($policy);
   }
}
OCP\Util::addScript ( 'piwik', 'track' );

?>
