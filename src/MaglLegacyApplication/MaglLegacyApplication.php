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

    /**
     *
     * @var string full path of the requested file (may be used within your legacy application)
     */
    private static $legacyRequestFilename = null;
    
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
    
    /**
     * 
     * @return string the full path of the requested legacy filename
     */
    public static function getLegacyRequestFilename()
    {
        return self::$legacyRequestFilename;
    }

    /**
     * 
     * @param string $legacyRequestFilename
     * @return true if the filename has been set
     * @throws Exception if the request filename has already been set
     */
    public static function setLegacyRequestFilename($legacyRequestFilename)
    {
        if(null === self::$legacyRequestFilename) {
            self::$legacyRequestFilename = $legacyRequestFilename;
            return true;
        }
        
        throw new Exception('legacyRequestFilename is already set to \''.self::$legacyRequestFilename.'\','.
            ' you are not allowed to change it');
    }


    
}
