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

    $allowedUrl = ' \'self\' ';
    $parseurl = parse_url($url);

    if (isset($parseurl['host']) && array_key_exists('HTTP_HOST', $_SERVER)
        && $_SERVER['HTTP_HOST'] !== $parseurl['host']) {
        $allowedUrl = $parseurl['host'];

        if (isset($parseurl['port'])) {
            $allowedUrl .= ':' . (string) $parseurl['port'];
        }
    }

    $policy = new OCP\AppFramework\Http\ContentSecurityPolicy();

    $policy->addAllowedScriptDomain($allowedUrl);
    $policy->addAllowedImageDomain($allowedUrl);

    \OC::$server->getContentSecurityPolicyManager()->addDefaultPolicy($policy);
}
