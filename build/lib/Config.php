<?php
namespace OCA\Piwik;

use OCP\IConfig;

class Config
{
    public function __construct($appName, IConfig $config)
    {
        $this->appName = $appName;
        $this->config = $config;
    }

    public function getAppValue($key, $default = null)
    {
        $value = $this->config->getAppValue($this->appName, $key, $default);
        return (empty($value)) ? $default : $value;
    }

    public function setAppValue($key, $value)
    {
        return $this->config->setAppValue($this->appName, $key, $value);
    }

    public function getBooleanAppValue($key)
    {
        return $this->validateBoolean($this->getAppValue($key));
    }

    private function validateBoolean($val)
    {
        return $val === true || $val === 'true';
    }
}
