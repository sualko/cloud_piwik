<?php

namespace OCA\Piwik\Migration;

use OCP\IConfig;
use OCP\Migration\IOutput;
use OCP\Migration\IRepairStep;

class Settings implements IRepairStep {
	/**
	 * @var IConfig
	 */
	private $config;

	public function __construct(IConfig $config) {
		$this->config = $config;
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
		$oldPiwikConfig = $config->getAppValue('piwik', 'piwik');

		if (!empty($oldPiwikConfig)) {
			$oldPiwikConfig = json_decode($oldPiwikConfig);
			$trackDir = $oldPiwikConfig->trackDir;

			$config->setAppValue('piwik', 'url', $oldPiwikConfig->url);
			$config->setAppValue('piwik', 'siteId', $oldPiwikConfig->siteId);
			$config->setAppValue('piwik', 'trackDir', $trackDir === 'on');

			$config->deleteAppValue('piwik', 'piwik');
		} else {
			$output->info("Migration already executed");
		}
	}
}
