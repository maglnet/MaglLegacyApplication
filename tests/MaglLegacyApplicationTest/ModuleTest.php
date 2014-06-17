<?php

namespace MaglLegacyApplicationTest;

use MaglLegacyApplication\Module;

/**
 * Description of ModuleTest
 *
 * @author matthias
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Module
     */
    private $instance;

    public function setUp()
    {
        $this->instance = new Module();
    }

    public function testInstance()
    {
        $this->assertInstanceOf('MaglLegacyApplication\Module', $this->instance);
    }

    public function testConfigSerializable()
    {
        $config = $this->instance->getConfig();

        $this->assertEquals($config, unserialize(serialize($config)));
    }

    public function testGetAutoloaderConfig()
    {
        $config = $this->instance->getAutoloaderConfig();

        $this->assertTrue(array_key_exists('MaglLegacyApplication', $config['Zend\Loader\StandardAutoloader']['namespaces']));
    }

    public function testGetServiceFactories()
    {
        $config = $this->instance->getServiceConfig();

        $this->assertTrue(array_key_exists('factories', $config));
        $this->assertTrue(array_key_exists('MaglLegacyApplicationOptions', $config['factories']));
    }

    public function testGetControllerConfig()
    {
        $config = $this->instance->getControllerConfig();

        $this->assertTrue(array_key_exists('factories', $config));
        $this->assertTrue(array_key_exists('MaglLegacyApplication\Controller\Legacy', $config['factories']));
    }

    public function testGetControllerFromServiceManager()
    {

        $sm = Bootstrap::getServiceManager();

        $controller = $sm->get('ControllerLoader')->get('MaglLegacyApplication\Controller\Legacy');

        $this->assertInstanceOf('\MaglLegacyApplication\Controller\LegacyController', $controller);
    }

    public function testGetLegacyControllerOptionsFromServiceManager()
    {

        $sm = Bootstrap::getServiceManager();

        $options = $sm->get('MaglLegacyApplicationOptions');

        $this->assertInstanceOf('\MaglLegacyApplication\Options\LegacyControllerOptions', $options);
    }
}
