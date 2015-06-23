<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplication;

use Zend\Mvc\Router\RouteMatch;
use Zend\ServiceManager\ServiceManager;

class Module
{

    public function getConfig()
    {
        return include realpath(__DIR__ . '/../../config/module.config.php');
    }

    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'MaglLegacyApplication\Controller\Legacy' => function ($sl) {
                    $options = $sl->getServiceLocator()->get('MaglLegacyApplicationOptions');

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
                'MaglLegacyApplicationOptions' => function ($sl) {
                    $config = $sl->get('Config');
                    $options = $config['magl_legacy_application'];

                    return new Options\LegacyControllerOptions($options);
                },
                'MaglControllerService' => function (ServiceManager $sl) {

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
