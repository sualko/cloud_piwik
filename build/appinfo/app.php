<?php
$url = \OC::$server->getConfig()->getAppValue('piwik', 'url');

if (!empty($url)) {
    \OCP\Util::addHeader(
        'script',
        [
            'src' => \OC::$server->getURLGenerator()->linkToRoute('piwik.JavaScript.tracking'),
            'nonce' => \OC::$server->getContentSecurityPolicyNonceManager()->getNonce(),
        ], ''
    );

    $url = parse_url($url, PHP_URL_HOST);
    $policy = new OCP\AppFramework\Http\ContentSecurityPolicy();

    if ($url !== false && array_key_exists('HTTP_HOST', $_SERVER)
        && $_SERVER['HTTP_HOST'] !== $url && !empty($url)) {
        $policy->addAllowedScriptDomain($url);
        $policy->addAllowedImageDomain($url);

        \OC::$server->getContentSecurityPolicyManager()->addDefaultPolicy($policy);
    }
}
