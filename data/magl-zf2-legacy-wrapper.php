<?php
/**
 * This is the index.php from the zf2 skeleton application
 * it was renamed to index-zf2-wrapper.php since the 
 * legacy application could have (and possibly already has) an index.php
 * 
 * additionally it uses MaglLegacyApplication::run() to be able to access the ZF2 mvc application from
 * within your legacy application
 */

define('REQUEST_MICROTIME', microtime(true));
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

require_once realpath(__DIR__ . '/../module/MaglLegacyApplication/src/MaglLegacyApplication/MaglLegacyApplication.php');
MaglLegacyApplication\MaglLegacyApplication::run(require 'config/application.config.php');