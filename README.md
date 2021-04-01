# MaglLegacyApplication - Legacy Applications in Laminas

[![Latest Stable Version](https://poser.pugx.org/maglnet/magl-legacy-application/v/stable.svg)](https://packagist.org/packages/maglnet/magl-legacy-application)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maglnet/MaglLegacyApplication/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/maglnet/MaglLegacyApplication/?branch=master)
[![License](https://poser.pugx.org/maglnet/magl-legacy-application/license.svg)](https://packagist.org/packages/maglnet/magl-legacy-application)
[![Build Status](https://travis-ci.org/maglnet/MaglLegacyApplication.svg?branch=master)](https://travis-ci.org/maglnet/MaglLegacyApplication)
[![Code Coverage](https://scrutinizer-ci.com/g/maglnet/MaglLegacyApplication/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/maglnet/MaglLegacyApplication/?branch=master)

Run your legacy applications within Laminas.

## Introduction
Since rewriting your legacy application from scratch to a Laminas application could be nearly impossible
due to time, effort, and resources, I was searching for a way to migrate a legacy application to a Laminas application.

A [great article by Chris Abernethy][1] described a way on how to run your legacy application within ZF1, so
I migrated this HowTo to a small Laminas module, to be able to run a legacy application within Laminas.

While running your legacy application within a Laminas application it is possible to slowly migrate an existing application
to Laminas by leaving your old application (nearly - see "Adjust your legacy Application") untouched and build new modules
with the power of Laminas.  
By adding a simple wrapper (see "Using Laminas within your legacy application") you could also use the new modules
within your legacy application. 


## Installation
Install through composer
```json
{
    "require" : {
        "maglnet/magl-legacy-application" : "*"
    }
}
```

Enable the module within your Laminas `application.config.php`
```php
    'modules' => array(
        'Application',
        'MaglLegacyApplication',
    ),
```

Copy the provided file `data/magl-laminas-legacy-wrapper.php` to your `public/` folder.  
Copy the provided file `data/.htaccess` to your publix folder.  
Copy your legacy Application to your `public/` folder.

Your legacy application should now run within Laminas. :)


## Configuration
For any SEO optimized route within your legacy application, add a route to the zend router that
routes to legacy controller and remove the mod_rewrite rules from your `.htaccess`
```php
return array(
    'router' => array(
        'routes' => array(
            // example for transferring mod rewrite rules to laminas routes
            'legacy-seo-calendar' => array(
                'type' => 'Laminas\Mvc\Router\Http\Regex',
                'options' => array(
                    'regex'    => '/calendar/(?<foo>.+)',
                    'defaults' => array(
                        'controller' => 'MaglLegacyApplication\Controller\Legacy',
                        'action'     => 'index',
                        'script'     => 'index-already-seo-optimized.php',
                    ),
                    'spec' => '/',
                ),
            ),
        ),
    ),
);
```

## Adjust your legacy Application
There are several cases in which your legacy application won't run without additional adjustments, here are some of them:

### Relative Paths
Using relative paths for `require`, `require_once` or `includes` will possibly fail now, since Laminas will do a `chdir()`
to the Laminas' application root. So you will need to adjust your paths to match the new root.

Example:

```php
include '../lib/somelib.php';
```

should be changed to:

```php
include __DIR__ . '/../lib/somelib.php';
```

### Using Globals / Server `SCRIPT_FILENAME` or `SCRIPT_NAME`
Because of `mod_rewrite` rules, `SCRIPT_FILENAME` and `SCRIPT_NAME` won't be your real script anymore. 
If you use these variables, you need to adjust these places within your legacy application:

Example:

```php
$script_filename = $_SERVER['SCRIPT_FILENAME'];
$script_name     = $_SERVER['SCRIPT_NAME'];
```

should be changed to:

```php
use MaglLegacyApplication\Application\MaglLegacy;
$legacy          = MaglLegacy::getInstance();
$script_filename = $legacy->getLegacyScriptFilename();
$script_name     = $legacy->getLegacyScriptName();

```

## Using Laminas within your legacy application
```php
use MaglLegacyApplication\Application\MaglLegacy;
$application = MaglLegacy::getInstance()->getApplication();
$yourService = $application->getServiceManager()->get('YourService');
```

## Injecting responses from within your legacy application
from wherever you are within your legacy application, it is possible to bypass your legacy applications controller code
and send a response to the Laminas Controller wrapper. This response will then be handled like within a normal Laminas controller.
```php
use MaglLegacyApplication\Application\MaglLegacy;
$application = MaglLegacy::getInstance()->getApplication();
$application->getEventManager()->getSharedManager()->attach('*', MaglLegacy::EVENT_SHORT_CIRCUIT_RESPONSE, function(Event $e){
    $response = new \Laminas\Http\Response();
    $response->setStatusCode(404);
    $response->setContent('not found');
    $e->stopPropagation(true);
    return $response;
});
```

# Contributing
If you have questions or problems regarding this module just open an issue or, even better,
solve it and open a pull request. :+1:

[1]: http://www.chrisabernethy.com/zend-framework-legacy-scripts/
