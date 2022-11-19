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

	$isHostDifferent = isset($parseurl['host']) && array_key_exists('SERVER_NAME', $_SERVER) && $_SERVER['SERVER_NAME'] !== $parseurl['host'];
	$isPortDifferent = isset($parseurl['port']) && array_key_exists('SERVER_PORT', $_SERVER) && $_SERVER['SERVER_PORT'] !== $parseurl['port'];

	if ($isHostDifferent || $isPortDifferent) {
		$allowedUrl = $parseurl['host'];

		if (isset($parseurl['port'])) {
			$allowedUrl .= ':' . (string) $parseurl['port'];
		}
	}

	$policy = new OCP\AppFramework\Http\ContentSecurityPolicy();

	$policy->addAllowedScriptDomain($allowedUrl);
	$policy->addAllowedImageDomain($allowedUrl);
	$policy->addAllowedConnectDomain($allowedUrl);

	\OC::$server->getContentSecurityPolicyManager()->addDefaultPolicy($policy);
}
