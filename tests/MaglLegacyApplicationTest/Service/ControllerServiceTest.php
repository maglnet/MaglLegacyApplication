<?php
/**
 * Created by PhpStorm.
 * User: mglaub
 * Date: 02.07.2015
 * Time: 09:17
 */

namespace MaglLegacyApplicationTest\Service;


use MaglLegacyApplication\Service\ControllerService;
use MaglLegacyApplicationTest\Bootstrap;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Controller\ControllerManager;
use Laminas\View\Model\ViewModel;

class ControllerServiceTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ControllerService
     */
    private $instance;

    public function setUp()
    {
        $this->instance = Bootstrap::getServiceManager()->get('MaglControllerService');
    }

    public function testControllerServiceIsRegistered()
    {
        $this->assertInstanceOf('MaglLegacyApplication\Service\ControllerService', $this->instance);
    }

    public function testRunControllerAction()
    {
        /** @var ControllerManager $controllerManager */
        $controllerManager = Bootstrap::getServiceManager()->get('ControllerManager');
        $controllerManager->setService('TestController', new TestController());
        $this->instance->runControllerAction('TestController', 'test');
    }

}

class TestController extends AbstractActionController
{
    public function testAction()
    {
        return new ViewModel();
    }
}
