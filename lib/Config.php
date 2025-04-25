<?php

namespace OCA\Piwik;

use OCA\Piwik\AppInfo\Application;
use OCP\IAppConfig;

class Config {
	private IAppConfig $config;

	public function __construct(IAppConfig $config) {
		$this->config = $config;
	}

	public function getAppValue(string $key, $default = null) {
		$value = $this->config->getValueString(Application::ID, $key, $default ?? '');
		return (empty($value)) ? $default : $value;
	}

	public function setAppValue(string $key, string $value) {
		return $this->config->setValueString(Application::ID, $key, $value);
	}

	public function getBooleanAppValue(string $key) {
		return $this->validateBoolean($this->getAppValue($key));
	}

	private function validateBoolean(mixed $val) {
		return $val === true || $val === 'true';
	}

	public function deleteAppValue(string $key) {
		return $this->config->deleteKey(Application::ID, $key);
	}
}
