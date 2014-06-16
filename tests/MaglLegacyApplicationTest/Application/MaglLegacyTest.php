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
    }
    
    /**
     * @covers \MaglLegacyApplication\Application\MaglLegacy::__clone
     */
    public function testClonePrivate(){
        
        $instance = MaglLegacy::getInstance();
        
        $reflectionClass = new \ReflectionClass($instance);

        $this->assertFalse($reflectionClass->isCloneable());
        
    }
    
    public function testConstructorPrivate(){
        
        $instance = MaglLegacy::getInstance();
        
        $reflectionClass = new \ReflectionClass($instance);

        $this->assertFalse($reflectionClass->isInstantiable());
        
    }
    
    public function testSetLegacyScriptName(){
        
        $scriptName = 'myscript.php';
        
        $instance = MaglLegacy::getInstance();
        $instance->setLegacyScriptName($scriptName);
        
        $this->assertEquals($scriptName, $instance->getLegacyScriptName());
        
        $this->assertFalse($instance->setLegacyScriptName('not-allowed-to-set-again.php'));
        
        $this->assertEquals($scriptName, $instance->getLegacyScriptName());        
        
    }
    
    public function testSetLegacyScriptFileName(){
        
        $scriptFileName = 'myscript.php';
        
        $instance = MaglLegacy::getInstance();
        $instance->setLegacyScriptFileName($scriptFileName);
        
        $this->assertEquals($scriptFileName, $instance->getLegacyScriptFileName());
        
        $this->assertFalse($instance->setLegacyScriptFileName('not-allowed-to-set-again.php'));
        
        $this->assertEquals($scriptFileName, $instance->getLegacyScriptFileName());        
        
    }
}
