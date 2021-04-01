<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplication;

use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature\AutoloaderProviderInterface;
use Laminas\ModuleManager\Feature\BootstrapListenerInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\Mvc\MvcEvent;
use MaglLegacyApplication\Application\MaglLegacy;

class Module implements BootstrapListenerInterface, ConfigProviderInterface, AutoloaderProviderInterface
{

    /**
     * @inheritDoc
     */
    public function onBootstrap(EventInterface $event)
    {
        if ($event instanceof MvcEvent) {
            MaglLegacy::getInstance()->setApplication($event->getApplication());
        }
    }

    /**
     * @inheritDoc
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @inheritDoc
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Laminas\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }
}
