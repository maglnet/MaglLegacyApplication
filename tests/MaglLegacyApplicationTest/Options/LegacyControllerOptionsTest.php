<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplicationTest\Options;

class LegacyControllerOptionsTest extends \PHPUnit_Framework_TestCase
{

    public function testSetGetDocRoot()
    {
        $options = new \MaglLegacyApplication\Options\LegacyControllerOptions();

        $docRoot = '/var/www/html/';

        $options->setDocRoot($docRoot);

        $this->assertSame($docRoot, $options->getDocRoot());
    }

    public function testSetGetGlobals()
    {
        $options = new \MaglLegacyApplication\Options\LegacyControllerOptions();

        $myGlobalsOptions = array(
            'get' => true,
            'request' => true,
        );

        $options->setGlobals($myGlobalsOptions);

        $this->assertSame($myGlobalsOptions, $options->getGlobals());
    }
}
