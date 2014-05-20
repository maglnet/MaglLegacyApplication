<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
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
