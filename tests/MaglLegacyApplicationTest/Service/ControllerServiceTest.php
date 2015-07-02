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



}
