<?php
namespace OCA\Piwik\Controller;

use OCP\AppFramework\Controller;
use OCP\IRequest;
use OCA\Piwik\Config;

class SettingsController extends Controller
{
    private $config;

    public function __construct(
        $appName,
        IRequest $request,
        Config $config
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
                'url' => $this->config->getAppValue('url'),
                'siteId' => $this->config->getAppValue('siteId'),
                'trackDir' => $this->config->getBooleanAppValue('trackDir')
            ],
        ];
    }

    public function update($key)
    {
        if (!in_array($key, ['url', 'siteId', 'trackDir', 'trackUser'])) {
            return [
                'result' => 'error',
                'message' => 'Tried to update not allowed param.',
            ];
        }

        $this->config->setAppValue($key, $this->getTrimParam('value'));

        return [
            'status' => 'success',
        ];
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
