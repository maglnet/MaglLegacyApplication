# MaglLegacyApplication - Legacy Applications in ZF2

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/maglnet/MaglLegacyApplication/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/maglnet/MaglLegacyApplication/?branch=master)

Run your legacy applications within Zend Framework 2.

## Introduction
A [great article by Chris Abernethy][1] described a way on how to run your legacy application within ZF1, so
I migrated this HowTo to a small ZF2 module.


## Installation
Install through composer
```json
{
    "require" : {
        "maglnet/magl-legacy-application" : "*"
    }
}
```

Copy the provided file `data/magl-zf2-legacy-wrapper.php` to your `public/` folder.
Copy the provided file `data/.htaccess` to your publix folder.
Copy your legacy Application to your `public/` folder.

Your legacy application should now run within ZF2. :)


## Configuration
For any SEO optimized route within your legacy application, add a route to the zend router that
routes to legacy controller and remove the mod_rewrite rules from your `.htaccess`
```php
return array(
    'router' => array(
        'routes' => array(
            // example for transferring mod rewrite rules to zf2 routes
            'legacy-seo-calendar' => array(
                'type' => 'Zend\Mvc\Router\Http\Regex',
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
If you use `require`, `require_once` or `include` inside your legacy application with relative paths,
you need to adjust those parts, since ZF2 does a chdir() to the application root.

## Using ZF2 within your legacy application
```php
MaglLegacyApplication::getApplication()->getServiceManager()->get('YourService');
```


[1]: http://www.chrisabernethy.com/zend-framework-legacy-scripts/