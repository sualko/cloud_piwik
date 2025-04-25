<?php

namespace OCA\Piwik\Migration;

use OCA\Piwik\Config;
use OCP\Migration\IOutput;
use OCP\Migration\IRepairStep;

class Settings implements IRepairStep {

	public function __construct(private Config $config) {
	}

	/**
	 * Returns the step's name
	 */
	public function getName() {
		return 'Update Piwik/Matomo settings format';
	}

	/**
	 * @param IOutput $output
	 */
	public function run(IOutput $output) {
		$config = $this->config;
		$oldPiwikConfig = $config->getAppValue('piwik');

		if (!empty($oldPiwikConfig)) {
			$oldPiwikConfig = json_decode($oldPiwikConfig);
			$trackDir = $oldPiwikConfig->trackDir;

			$config->setAppValue('url', $oldPiwikConfig->url);
			$config->setAppValue('siteId', $oldPiwikConfig->siteId);
			$config->setAppValue('trackDir', $trackDir === 'on');

			$config->deleteAppValue('piwik');
		} else {
			$output->info("Migration already executed");
		}
	}
}
