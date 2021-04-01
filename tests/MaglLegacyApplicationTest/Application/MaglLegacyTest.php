<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplicationTest\Application;

use MaglLegacyApplication\Application\MaglLegacy;
use PHPUnit_Framework_TestCase;

class MaglLegacyTest extends PHPUnit_Framework_TestCase
{

    public function testGetInstance()
    {
        $instance = MaglLegacy::getInstance();
        $this->assertInstanceOf('\MaglLegacyApplication\Application\MaglLegacy', $instance);

        $instance2 = MaglLegacy::getInstance();

        $this->assertSame($instance2, $instance);
    }

    /**
     * @covers \MaglLegacyApplication\Application\MaglLegacy::__clone
     */
    public function testClonePrivate()
    {
        if (!class_exists('\ReflectionClass')) {
            $this->markTestSkipped('no reflection api available');
        }

        $instance = MaglLegacy::getInstance();

        $reflectionClass = new \ReflectionClass($instance);

        if (!method_exists($reflectionClass, 'isCloneable')) {
            $this->markTestSkipped('no isClonable test available');
        }

        $this->assertFalse($reflectionClass->isCloneable());
    }

    public function testConstructorPrivate()
    {
        if (!class_exists('\ReflectionClass')) {
            $this->markTestSkipped('no reflection api available');
        }

        $instance = MaglLegacy::getInstance();

        $reflectionClass = new \ReflectionClass($instance);

        if (!method_exists($reflectionClass, 'isInstantiable')) {
            $this->markTestSkipped('no isInstantiable test available');
        }

        $this->assertFalse($reflectionClass->isInstantiable());
    }

    public function testSetGetLegacyScriptName()
    {
        $scriptName = 'myscript.php';

        $instance = MaglLegacy::getInstance();
        $instance->setLegacyScriptName($scriptName);

        $this->assertEquals($scriptName, $instance->getLegacyScriptName());

        $this->assertFalse($instance->setLegacyScriptName('not-allowed-to-set-again.php'));

        $this->assertEquals($scriptName, $instance->getLegacyScriptName());
    }

    public function testSetGetLegacyScriptFileName()
    {
        $scriptFileName = 'myscript.php';

        $instance = MaglLegacy::getInstance();
        $instance->setLegacyScriptFileName($scriptFileName);

        $this->assertEquals($scriptFileName, $instance->getLegacyScriptFileName());

        $this->assertFalse($instance->setLegacyScriptFileName('not-allowed-to-set-again.php'));

        $this->assertEquals($scriptFileName, $instance->getLegacyScriptFileName());
    }

    public function testSetGetApplication()
    {
        $appMock = $this->getMockBuilder('Laminas\Mvc\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $instance = MaglLegacy::getInstance();

        $instance->setApplication($appMock);

        $this->assertSame($appMock, $instance->getApplication());
    }
}
