<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplication;

use MaglLegacyApplication\Application\MaglLegacy;
use Psr\Container\ContainerInterface;
use Zend\Mvc\MvcEvent;
use Zend\Router\RouteMatch;
use Zend\ServiceManager\ServiceManager;

class Module
{
    public function onBootstrap(MvcEvent $event)
    {
        MaglLegacy::getInstance()->setApplication($event->getApplication());
    }

    public function getConfig()
    {
        return include realpath(__DIR__ . '/../../config/module.config.php');
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'MaglLegacyApplication\Controller\Legacy' => function (ContainerInterface $container) {

                    $options = $container->get('MaglLegacyApplicationOptions');

                    $legacyApp = Application\MaglLegacy::getInstance();

                    return new \MaglLegacyApplication\Controller\LegacyController($options, $legacyApp);
                }
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'MaglLegacyApplicationOptions' => function (ContainerInterface $sl) {
                    $config = $sl->get('Config');
                    $options = $config['magl_legacy_application'];

                    return new Options\LegacyControllerOptions($options);
                },
                'MaglControllerService' => function (ContainerInterface $sl) {

                    $eventManager = $sl->get('Application')->getEventManager();

                    $event = new \Zend\Mvc\MvcEvent();
                    $event->setApplication($sl->get('Application'));
                    $event->setTarget($sl->get('Application'));
                    $event->setRequest($sl->get('Request'));
                    $event->setRouter($sl->get('Router'));
                    $event->setRouteMatch(new RouteMatch(array()));

                    return new Service\ControllerService($eventManager, $event);
                }
            )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }
}
