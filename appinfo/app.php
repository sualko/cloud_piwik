<?php
$url = \OC::$server->getConfig()->getAppValue('piwik', 'url');

if (!empty($url)) {
    OCP\Util::addScript('piwik', 'track');

    if (class_exists('\\OCP\\AppFramework\\Http\\ContentSecurityPolicy')) {
        $url = parse_url($url, PHP_URL_HOST);

        $policy = new OCP\AppFramework\Http\ContentSecurityPolicy();
        $policy->addAllowedScriptDomain('\'self\' ');
        $policy->addAllowedImageDomain('\'self\' ');

        if ($url !== false && array_key_exists('HTTP_HOST', $_SERVER)
            && $_SERVER['HTTP_HOST'] !== $url && !empty($url)) {
            $policy->addAllowedScriptDomain($url);
            $policy->addAllowedImageDomain($url);
        }

        \OC::$server->getContentSecurityPolicyManager()->addDefaultPolicy($policy);
    }
}
