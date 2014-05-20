<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */


return array(
    'router' => array(
        'routes' => array(
            'legacy' => array(
                'type' => 'Zend\Mvc\Router\Http\Regex',
                'options' => array(
                    'regex'    => '(?<script>.+\.php)',
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
    'controllers' => array(
        'invokables' => array(
            'MaglLegacyApplication\Controller\Legacy' => 'MaglLegacyApplication\Controller\LegacyController',
        ),
    ),
);
