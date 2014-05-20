# MaglLegacyApplication - Legacy Applications in ZF2

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
Have a look at the provided `config/.htaccess`, to see mod rewrite rules. 
You could also use the rules provided by the ZF2 Skeleton Application.

In your `public/index.php`: Replace `Application::run()` with `MaglLegacyApplication::run()`,
so you can access the ZF2 application from your legacy Application by calling `MaglLegacyApplication::getApplication()`.

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
If you use `require` with relative paths, you need to adjust those parts, since ZF2 does a chdir() to the application root.

## Using ZF2 within your legacy application
```php
MaglLegacyApplication::getApplication()->getServiceManager()->get('YourService');
```


[1]: http://www.chrisabernethy.com/zend-framework-legacy-scripts/