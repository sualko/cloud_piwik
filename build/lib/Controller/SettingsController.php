<?php
namespace OCA\Piwik\Controller;

use OCP\AppFramework\Controller;
use OCP\IConfig;
use OCP\IRequest;

class SettingsController extends Controller
{
    private $config;

    public function __construct(
        $appName,
        IRequest $request,
        IConfig $config
    ) {
        parent::__construct($appName, $request);

        $this->config = $config;
    }

    /**
     * @NoAdminRequired
     * @PublicPage
     */
    public function index()
    {
        return [
            'result' => 'success',
            'data' => [
                'url' => $this->getAppValue('url'),
                'siteId' => $this->getAppValue('siteId'),
                'trackDir' => $this->getBooleanAppValue('trackDir'),
                'validity' => 2*60,
            ],
        ];
    }

    public function update($key)
    {
        if (!in_array($key, ['url', 'siteId', 'trackDir'])) {
            return [
                'result' => 'error',
                'message' => 'Tried to update not allowed param.',
            ];
        }

        $this->setAppValue($key, $this->getTrimParam('value'));

        return [
            'status' => 'success',
        ];
    }

    private function getAppValue($key, $default = null)
    {
        $value = $this->config->getAppValue($this->appName, $key, $default);
        return (empty($value)) ? $default : $value;
    }

    private function setAppValue($key, $value)
    {
        return $this->config->setAppValue($this->appName, $key, $value);
    }

    private function getBooleanAppValue($key)
    {
        return $this->validateBoolean($this->getAppValue($key));
    }

    private function validateBoolean($val)
	{
		return $val === true || $val === 'true';
	}

    private function getTrimParam($key)
    {
        return trim($this->request->getParam($key));
    }

    private function getCheckboxParam($key)
    {
        return $this->getCheckboxValue($this->request->getParam($key));
    }

    private function getCheckboxValue($var)
    {
        return (isset($var)) ? $var : 'false';
    }
}
