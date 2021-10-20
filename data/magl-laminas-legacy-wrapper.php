<?php
/**
 * This is the index.php from the zf2 skeleton application
 * it was renamed to magl-laminas-legacy-wrapper.php since the
 * legacy application could have (and possibly already has) an index.php
 *
 * additionally it uses MaglLegacyApplication::run() to be able to access the Laminas mvc application from
 * within your legacy application
 */

define('REQUEST_MICROTIME', microtime(true));
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    include __DIR__ . '/../vendor/autoload.php';
} else {
    die('please use composer to install all dependencies.');
}

if (file_exists('config/application.config.php')) {
    $application = Laminas\Mvc\Application::init(require 'config/application.config.php');
    \MaglLegacyApplication\Application\MaglLegacy::getInstance()->setApplication($application);
    $application->run();
} else {
    die('please provide a valid configuration file at "config/application.config.php"');
}
