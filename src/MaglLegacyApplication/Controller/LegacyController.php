<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplication\Controller;

class LegacyController extends \Zend\Mvc\Controller\AbstractActionController
{
    
    public function __construct()
    {
        //todo: set options, such as "set $_GET", "set $_REQUEST" etc
    }

    public function indexAction()
    {
        $docroot = getcwd().'/public';
        $uri = '/' . ltrim($this->params('script'), '/'); // Force leading '/'
        
        
        if (!file_exists($docroot . $uri)) {
            // if we're here, the file doesn't really exist and we do not know what to do
            $this->getResponse()->setStatusCode(404);
            return;
        }            
        
        $this->setGetVariables();

        ob_start();
        include $docroot . $uri;
        $output = ob_get_clean();
        $this->getResponse()->setContent($output);
        return $this->getResponse();
        
    }
    
    private function setGetVariables(){
        
        // check if $_GET is used at all (ini - variables_order ?)
        // check if $_GET is written to $_REQUEST (ini - variables_order / request_order)
        // depending on request_order, check if $_REQUEST is already written and decide if we are allowed to override
        
        $request_order = ini_get('request_order');
        
        if($request_order === false){
            $request_order = ini_get('variables_order');
        }
        
        $get_prio = stripos($request_order, 'g');
        $post_prio = stripos($request_order, 'p');
        
        $forceOverrideRequest = $get_prio > $post_prio;
        
        
        $routeParams = $this->getEvent()->getRouteMatch()->getParams();
        
        foreach($routeParams as $paramName => $paramValue){
            $_GET[$paramName] = $paramValue;
            if($forceOverrideRequest || !isset($_REQUEST[$paramName])){
                $_REQUEST[$paramName] = $paramValue;
            }
        }
        
    }
}
