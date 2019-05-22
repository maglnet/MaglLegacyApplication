<?php


namespace MaglLegacyApplication\Factory;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use MaglLegacyApplication\Service\ControllerService;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch as ZF2RouteMatch;
use Zend\Router\RouteMatch;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ControllerServiceFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this->__invoke($serviceLocator, 'MaglControllerService');
    }

    /**
     * Create an object
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $eventManager = $container->get('Application')->getEventManager();

        $event = new MvcEvent();
        $event->setApplication($container->get('Application'));
        $event->setTarget($container->get('Application'));
        $event->setRequest($container->get('Request'));
        $event->setRouter($container->get('Router'));

        $routeMatch = null;
        if(class_exists('\Zend\Mvc\Router\RouteMatch')) {
            // ZF2.5 compatibility
            $routeMatch = new ZF2RouteMatch(array());
        } else {
            $routeMatch = new RouteMatch(array());
        }
        $event->setRouteMatch($routeMatch);

        return new ControllerService($eventManager, $event);
    }
}
