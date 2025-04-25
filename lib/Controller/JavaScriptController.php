<?php

namespace OCA\Piwik\Controller;

use OCA\Piwik\Config;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataDownloadResponse;
use OCP\AppFramework\Http\Response;
use OCP\IRequest;

class JavaScriptController extends Controller {

	/**
	 * constructor of the controller
	 *
	 * @param string $appName
	 * @param IRequest $request
	 * @param Config $config
	 */
	public function __construct($appName,
		IRequest $request,
		private Config $config) {
		parent::__construct($appName, $request);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 * @PublicPage
	 *
	 * @return Response
	 */
	public function tracking() {
		$options = [
			'url' => $this->config->getAppValue('url'),
			'siteId' => $this->config->getAppValue('siteId'),
			'trackDir' => $this->config->getBooleanAppValue('trackDir'),
			'trackUser' => $this->config->getBooleanAppValue('trackUser'),
		];

		$script = "var cloudPiwikOptions = '".json_encode($options)."';";
		$script = file_get_contents(__DIR__ . '/../../js/track.js');
		$script = str_replace('%OPTIONS%', json_encode($options), $script);

		return new DataDownloadResponse($script, 'tracking', 'text/javascript');
	}
}
