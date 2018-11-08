<?php

/**
 * @author Matthias Glaub <magl@magl.net>
 * @license http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 */

namespace MaglLegacyApplication\Controller;

use MaglLegacyApplication\Application\MaglLegacy;
use MaglLegacyApplication\Options\LegacyControllerOptions;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class LegacyController extends AbstractActionController
{

    /**
     *
     * @var LegacyControllerOptions
     */
    private $options;

    /**
     *
     * @var MaglLegacy
     */
    private $legacy;

    public function __construct(LegacyControllerOptions $options, MaglLegacy $legacy)
    {
        $this->options = $options;
        $this->legacy = $legacy;
    }

    public function indexAction()
    {
        $docRoots = $this->options->getDocRoots();
        foreach($docRoots as $key => $docRoot) {
            $docRoots[$key] = rtrim(getcwd() . '/' . $docRoot);
        }

        $scriptName = $this->params('script');

        if (empty($scriptName)) {
            $path = $this->params(('path')) ? $this->params('path') : '';
            foreach ($this->options->getIndexFiles() as $indexFile) {
                foreach($docRoots as $docRoot) {
                    if (is_file($docRoot . '/' . $path . $indexFile)) {
                        $this->legacy->setLegacyScriptName($path . $indexFile);
                        return $this->runScript($docRoot . '/' . $path . $indexFile);
                    }
                }
            }
        }


        $scriptUri = '/' . ltrim($scriptName, '/'); // force leading '/'
        foreach($docRoots as $docRoot) {
            $legacyScriptFilename = $docRoot . $scriptUri;
            if(is_file($legacyScriptFilename)) {
                //inform the application about the used script
                $this->legacy->setLegacyScriptName($scriptUri);

                //inject get and request variables
                $this->setGetVariables();

                return $this->runScript($legacyScriptFilename);
            }
        }

        // if we're here, the file doesn't really exist and we do not know what to do
        $response = $this->getResponse();

        /* @var $response Response */ //<-- this one for netbeans (WHY, NetBeans, WHY??)
        /** @var Response $response */ // <-- this one for other IDEs and code analyzers :)
        $response->setStatusCode(404);
        return $response;
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

            if ($globals_options['get'] && !isset($_GET[$paramName])) {
                $_GET[$paramName] = $paramValue;
            }

            if ($globals_options['request'] && ($forceOverrideRequest || !isset($_REQUEST[$paramName]))) {
                $_REQUEST[$paramName] = $paramValue;
            }
        }
    }

    private function runScript($scriptFileName)
    {
        $this->legacy->setLegacyScriptFilename($scriptFileName);

        ob_start();
        $result = include $scriptFileName;
        $output = ob_get_clean();

        if ($result instanceof ViewModel || $result instanceof Response) {
            return $result;
        }

        $result = $this->getEventManager()->trigger(MaglLegacy::EVENT_SHORT_CIRCUIT_RESPONSE, $this);
        if ($result->stopped()) {
            if ($this->options->getPrependOutputBufferToResponse()) {
                $result->last()->setContent($output . $result->last()->getContent());
            }
            return $result->last();
        }

        $this->getResponse()->setContent($output);
        return $this->getResponse();
    }
}
