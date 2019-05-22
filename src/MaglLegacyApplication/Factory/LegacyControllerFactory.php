<?php


namespace MaglLegacyApplication\Factory;


use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use MaglLegacyApplication\Application\MaglLegacy;
use MaglLegacyApplication\Controller\LegacyController;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class LegacyControllerFactory implements FactoryInterface
{

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return mixed
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return $this->__invoke($serviceLocator->getServiceLocator(), 'MaglLegacyApplication\Controller\Legacy');
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
        $options = $container->get('MaglLegacyApplicationOptions');

        $legacyApp = MaglLegacy::getInstance();

        return new LegacyController($options, $legacyApp);
    }
}
