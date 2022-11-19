<?php

namespace OCA\Piwik\AppInfo;

use OC\Security\CSP\ContentSecurityPolicyManager;
use OC\Security\CSP\ContentSecurityPolicyNonceManager;
use OCP\AppFramework\App;
use OCP\AppFramework\Bootstrap\IBootContext;
use OCP\AppFramework\Bootstrap\IBootstrap;
use OCP\AppFramework\Bootstrap\IRegistrationContext;
use OCP\AppFramework\Http\ContentSecurityPolicy;
use OCP\IConfig;
use OCP\IURLGenerator;
use OCP\Util;

class Application extends App implements IBootstrap {
	public const ID = 'piwik';

	public function __construct(array $urlParams = []) {
		parent::__construct(self::ID, $urlParams);
	}

	public function register(IRegistrationContext $context): void {
	}

	public function boot(IBootContext $context): void {
		$context->injectFn([$this, 'addTrackingScript']);
		$context->injectFn([$this, 'addContentSecurityPolicy']);
	}

	public function addTrackingScript(IURLGenerator $urlGenerator, ContentSecurityPolicyNonceManager $nonceManager):void {
		Util::addHeader(
			'script',
			[
				'src' => $urlGenerator->linkToRoute('piwik.JavaScript.tracking'),
				'nonce' => $nonceManager->getNonce(),
			], ''
		);
	}

	public function addContentSecurityPolicy(IConfig $config, ContentSecurityPolicyManager $policyManager): void {
		$url = $config->getAppValue('piwik', 'url');
		$allowedUrl = ' \'self\' ';
		$parseUrl = parse_url($url);

		$isHostDifferent = isset($parseUrl['host']) && array_key_exists('SERVER_NAME', $_SERVER) && $_SERVER['SERVER_NAME'] !== $parseUrl['host'];
		$isPortDifferent = isset($parseUrl['port']) && array_key_exists('SERVER_PORT', $_SERVER) && $_SERVER['SERVER_PORT'] !== $parseUrl['port'];

		if ($isHostDifferent || $isPortDifferent) {
			$allowedUrl = $parseUrl['host'];

			if (isset($parseUrl['port'])) {
				$allowedUrl .= ':' . (string) $parseUrl['port'];
			}
		}

		$policy = new ContentSecurityPolicy();

		$policy->addAllowedScriptDomain($allowedUrl);
		$policy->addAllowedImageDomain($allowedUrl);
		$policy->addAllowedConnectDomain($allowedUrl);

		$policyManager->addDefaultPolicy($policy);
	}
}
