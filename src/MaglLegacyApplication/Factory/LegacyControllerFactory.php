<?php

namespace MaglLegacyApplication\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use MaglLegacyApplication\Application\MaglLegacy;
use MaglLegacyApplication\Controller\LegacyController;

class LegacyControllerFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options = $container->get('MaglLegacyApplicationOptions');

        $legacyApp = MaglLegacy::getInstance();

        return new LegacyController($options, $legacyApp);
    }
}
