<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplication;

use Zend\Mvc\Application;

class MaglLegacyApplication
{
    
    /**
     *
     * @var Application
     */
    private static $application;

    public static function run($config)
    {
        // Run the application!
        self::$application = Application::init($config);
        self::$application->run();
    }

    /**
     * 
     * @return Application
     */
    public static function getApplication()
    {
        return self::$application;
    }
    
}
