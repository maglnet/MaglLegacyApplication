<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

use MaglLegacyApplication\Factory\ControllerServiceFactory;
use MaglLegacyApplication\Factory\LegacyControllerFactory;
use MaglLegacyApplication\Factory\LegacyControllerOptionsFactory;

return array(
    'service_manager' => array(
        'factories' => array(
            'MaglLegacyApplicationOptions' => LegacyControllerOptionsFactory::class,
            'MaglControllerService' => ControllerServiceFactory::class,
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'MaglLegacyApplication\Controller\Legacy' => LegacyControllerFactory::class,
        ),
    ),
    'magl_legacy_application' => array(
        'doc_root' => array('public/'), // the legacy apps DOCUMENT_ROOT (can be more than one) for including files
        'globals' => array(
            'get' => true, // should $_GET be filled with variables from route match?
            'request' => true, // should $_GET be filled with variables from route match?
        ),
    ),
    'router' => array(
        'routes' => array(
            'legacy' => array(
                'type' => 'Regex',
                'options' => array(
                    'regex'    => '(?<script>.+\.php)|/',
                    'defaults' => array(
                        'controller' => 'MaglLegacyApplication\Controller\Legacy',
                        'action'     => 'index',
                    ),
                    'spec' => '/',
                ),
            ),
            // example for transferring mod rewrite rules to zf2 routes
//            'legacy-seo-calendar' => array(
//                'type' => 'Zend\Mvc\Router\Http\Regex',
//                'options' => array(
//                    'regex'    => '/calendar/(?<foo>.+)',
//                    'defaults' => array(
//                        'controller' => 'MaglLegacyApplication\Controller\Legacy',
//                        'action'     => 'index',
//                        'script'     => 'index-seo.php',
//                    ),
//                    'spec' => '/',
//                ),
//            ),
        ),
    ),
);
