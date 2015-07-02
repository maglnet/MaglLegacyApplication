<?php
/**
 * Created by PhpStorm.
 * User: mglaub
 * Date: 22.06.2015
 * Time: 15:53
 */

namespace MaglLegacyApplication\Service;


use Zend\EventManager\Event;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use MaglLegacyApplication\Application\MaglLegacy;
use Zend\Mvc\View\Http\ViewManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
use Zend\View\ViewEvent;

class ControllerService
{

    /**
     * @var MvcEvent
     */
    private $event;

    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var RouteMatch
     */
    private $routeMatch;

    public function __construct(EventManager $eventManager, MvcEvent $event)
    {
        $this->eventManager = $eventManager;
        $this->event = $event;
    }

    /**
     * @param $controllerName
     * @param $action
     * @param array $params
     * @return string|\Zend\Stdlib\ResponseInterface
     * @throws \Exception
     */
    public function runControllerAction($controllerName, $action, $params = array())
    {

        $this->event->getRouteMatch()
            ->setParam('controller', $controllerName)
            ->setParam('action', $action);

        foreach ($params as $key => $value) {
            $this->event->getRouteMatch()->setParam($key, $value);
        }

        $serviceManager = $this->event->getApplication()->getServiceManager();
        $controllerManager = $serviceManager->get('ControllerLoader');

        /** @var AbstractActionController $controller */
        $controller = $controllerManager->get($controllerName);

        $controller->setEvent($this->event);
        $result = $controller->dispatch($this->event->getRequest());

        if ($result instanceof Response) {
            return $result;
        }

        /** @var ViewManager $viewManager */
        $viewManager = $serviceManager->get('ViewManager');
        $renderingStrategy = $viewManager->getMvcRenderingStrategy();

        $this->event->setViewModel($result);

        /** @var ViewModel $result */
        if (!$result->terminate()) {
            $layout = new ViewModel();
            $layoutTemplate = $renderingStrategy->getLayoutTemplate();
            $layout->setTemplate($layoutTemplate);
            $layout->addChild($result);
            $this->event->setViewModel($layout);

        }

        $response = $renderingStrategy->render($this->event);

        return $response;
    }

}