<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplicationTest\Controller;

use MaglLegacyApplication\Options\LegacyControllerOptions;
use MaglLegacyApplicationTest\Bootstrap;
use Laminas\Stdlib\ResponseInterface;
use Laminas\View\Model\ViewModel;

class LegacyControllerTest extends \Laminas\Test\PHPUnit\Controller\AbstractHttpControllerTestCase
{

    protected $traceError = true;

    public function setUp()
    {
        $sm = \MaglLegacyApplicationTest\Bootstrap::getServiceManager();
        $this->setApplicationConfig($sm->get('ApplicationConfig'));

        parent::setUp();
    }

    private function defaultControllerCheck()
    {
        $this->assertModuleName('MaglLegacyApplication');
        $this->assertControllerName('MaglLegacyApplication\Controller\Legacy');
        $this->assertControllerClass('LegacyController');
    }

    public function testIndexAction()
    {
        $this->dispatch('/legacy-index.php');

        $this->assertEquals(200, $this->getResponseStatusCode());

        $this->defaultControllerCheck();
    }

    public function testFindFileInSecondDocRoot()
    {
        $this->dispatch('/legacy-index-alternative.php');

        $this->assertEquals(200, $this->getResponseStatusCode());

        $this->defaultControllerCheck();
    }

    public function testNotfound()
    {
        $this->dispatch('/no-index.php');
        $this->assertEquals(404, $this->getResponseStatusCode());

        $this->defaultControllerCheck();
    }

    public function testMustNotReturnResponseOnDefault404()
    {
        $this->dispatch('/no-index.php');

        $this->assertEquals(404, $this->getResponseStatusCode());
        $this->assertNotInstanceOf(ResponseInterface::class, $this->getApplication()->getMvcEvent()->getResult());

        $this->defaultControllerCheck();
    }

    public function testIndexActionSEO()
    {
        $this->assertFalse(array_key_exists('foo', $_GET));
        $this->assertFalse(array_key_exists('foo', $_REQUEST));

        $this->dispatch('/calendar/bar');

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->defaultControllerCheck();

        //testing if get and request are now set
        $this->assertEquals('bar', $_GET['foo']);
        $this->assertEquals('bar', $_REQUEST['foo']);

        $this->defaultControllerCheck();
    }

    public function testControllerReturnsGivenViewModel()
    {
        $this->dispatch('/returning-legacy-template.php');

        $this->assertEquals(200, $this->getResponseStatusCode());
        $this->assertTemplateName("legacy-template");

        $this->defaultControllerCheck();
    }

    public function testControllerReturnsResponse()
    {
        $this->dispatch('/returning-legacy-response.php');

        $this->assertEquals(418, $this->getResponseStatusCode());
        $this->assertEquals('myResponse', $this->getResponse()->getContent());

        $this->defaultControllerCheck();
    }
}
