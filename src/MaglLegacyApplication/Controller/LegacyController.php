<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplication\Controller;

class LegacyController extends \Zend\Mvc\Controller\AbstractActionController
{

    /**
     *
     * @var \MaglLegacyApplication\Options\LegacyControllerOptions
     */
    private $options;

    /**
     * filename of the requested script
     * @var string
     */
    private $legacyScriptFilename;

    public function __construct(\MaglLegacyApplication\Options\LegacyControllerOptions $options)
    {
        $this->options = $options;
    }

    public function indexAction()
    {
        $docroot = getcwd() . '/' . $this->options->getDocRoot();
        $docroot = rtrim($docroot, '/');
        $scriptUri = '/' . ltrim($this->params('script'), '/'); // force leading '/'
        $this->legacyScriptFilename = $docroot . $scriptUri;

        if (!file_exists($this->legacyScriptFilename)) {
            // if we're here, the file doesn't really exist and we do not know what to do
            $response = $this->getResponse();
            
            /* @var $response \Zend\Http\Response */ //<-- this one for netbeans (WHY, NetBeans, WHY??)
            /** @var \Zend\Http\Response $response */ // <-- this one for other IDEs and code analyzers :)
            $response->setStatusCode(404);

            return;
        }

        //inform the application about the used script
        \MaglLegacyApplication\MaglLegacyApplication::setLegacyScriptFilename($this->legacyScriptFilename);
        \MaglLegacyApplication\MaglLegacyApplication::setLegacyScriptName($scriptUri);

        //inject get and request variables
        $this->setGetVariables();

        ob_start();
        include $this->legacyScriptFilename;
        $output = ob_get_clean();
        $this->getResponse()->setContent($output);

        return $this->getResponse();
    }

    private function setGetVariables()
    {
        $globals_options = $this->options->getGlobals();

        // if we should not set any global vars, we can return safely
        if (!$globals_options['get'] && !$globals_options['request']) {
            return;
        }

        // check if $_GET is used at all (ini - variables_order ?)
        // check if $_GET is written to $_REQUEST (ini - variables_order / request_order)
        // depending on request_order, check if $_REQUEST is already written and decide if we are allowed to override

        $request_order = ini_get('request_order');

        if ($request_order === false) {
            $request_order = ini_get('variables_order');
        }

        $get_prio = stripos($request_order, 'g');
        $post_prio = stripos($request_order, 'p');

        $forceOverrideRequest = $get_prio > $post_prio;

        $routeParams = $this->getEvent()->getRouteMatch()->getParams();

        foreach ($routeParams as $paramName => $paramValue) {

            if ($globals_options['get']) {
                $_GET[$paramName] = $paramValue;
            }

            if ($globals_options['request'] && ($forceOverrideRequest || !isset($_REQUEST[$paramName]))) {
                $_REQUEST[$paramName] = $paramValue;
            }
        }
    }
}
