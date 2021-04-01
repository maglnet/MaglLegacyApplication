<?php

namespace MaglLegacyApplication\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use MaglLegacyApplication\Options\LegacyControllerOptions;

class LegacyControllerOptionsFactory implements FactoryInterface
{

    /**
     * @inheritDoc
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $options = $config['magl_legacy_application'];

        return new LegacyControllerOptions($options);
    }
}
