<?php

namespace MaglLegacyApplication\Factory;

use Interop\Container\ContainerInterface;
use Laminas\Mvc\MvcEvent;
use Laminas\Router\RouteMatch;
use Laminas\ServiceManager\Factory\FactoryInterface;
use MaglLegacyApplication\Service\ControllerService;

class ControllerServiceFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $eventManager = $container->get('Application')->getEventManager();

        $event = new MvcEvent();
        $event->setApplication($container->get('Application'));
        $event->setTarget($container->get('Application'));
        $event->setRequest($container->get('Request'));
        $event->setRouter($container->get('Router'));

        $routeMatch = new RouteMatch(array());

        $event->setRouteMatch($routeMatch);

        return new ControllerService($eventManager, $event);
    }
}
