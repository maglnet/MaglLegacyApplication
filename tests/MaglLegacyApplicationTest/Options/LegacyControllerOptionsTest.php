<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplicationTest\Options;

use PHPUnit\Framework\TestCase;

class LegacyControllerOptionsTest extends TestCase
{

    public function testSetGetDocRoot()
    {
        $options = new \MaglLegacyApplication\Options\LegacyControllerOptions();

        $docRoot = '/var/www/html/';

        $options->setDocRoot($docRoot);

        $this->assertSame($docRoot, $options->getDocRoot());
    }

    public function testSetGetDocRoots()
    {
        $options = new \MaglLegacyApplication\Options\LegacyControllerOptions();

        $docRoots = array('/var/www/html/', '/var/www/htdocs');

        $options->setDocRoot($docRoots);

        $this->assertSame($docRoots, $options->getDocRoots());
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
