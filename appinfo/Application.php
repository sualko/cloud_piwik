<?php
namespace OCA\Piwik\AppInfo;

use OCA\Piwik\Controller\SettingsController;
use OCA\Piwik\Migration\Settings as SettingsMigration;
use OCP\AppFramework\App;
use OCP\IContainer;

class Application extends App
{

    public function __construct(array $urlParams = array())
    {
        parent::__construct('piwik', $urlParams);

        $container = $this->getContainer();

        /**
         * Controllers
         */
        $container->registerService('SettingsController', function (IContainer $c) {
            return new SettingsController(
                $c->query('AppName'),
                $c->query('Request'),
                $c->query('OCP\IConfig')
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
