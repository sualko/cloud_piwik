<?php
namespace OCA\Piwik\AppInfo;

use OCA\Piwik\Config;
use OCA\Piwik\Controller\SettingsController;
use OCA\Piwik\Controller\JavaScriptController;
use OCA\Piwik\Migration\Settings as SettingsMigration;
use OCP\AppFramework\App;
use OCP\IContainer;

class Application extends App
{

    public function __construct(array $urlParams = array())
    {
        parent::__construct('piwik', $urlParams);

        $container = $this->getContainer();

        $container->registerService('OCA\Piwik\Config', function (IContainer $c) {
            return new Config(
                $c->query('AppName'),
                $c->query('OCP\IConfig')
            );
        });

        /**
         * Controllers
         */
        $container->registerService('SettingsController', function (IContainer $c) {
            return new SettingsController(
                $c->query('AppName'),
                $c->query('Request'),
                $c->query('OCA\Piwik\Config')
            );
        });

        $container->registerService('JavaScriptController', function (IContainer $c) {
            return new JavaScriptController(
                $c->query('AppName'),
                $c->query('Request'),
                $c->query('OCA\Piwik\Config')
            );
        });

        /**
         * Migrations
         */
        $container->registerService('OCA\Piwik\Migration\Settings', function (IContainer $c) {
            return new SettingsMigration(
                $c->query('OCP\IConfig')
            );
        });
    }
}
