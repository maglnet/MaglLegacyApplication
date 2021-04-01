<?php
/**
 * Created by PhpStorm.
 * User: mglaub
 * Date: 22.06.2015
 * Time: 15:53
 */

namespace MaglLegacyApplication\Service;

use Laminas\EventManager\EventManager;
use Laminas\Http\Response;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\MvcEvent;
use Laminas\Mvc\View\Http\DefaultRenderingStrategy;
use Laminas\Router\RouteMatch;
use Laminas\Stdlib\ResponseInterface;
use Laminas\View\Model\ViewModel;

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
     * @return string|ResponseInterface
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
        $controllerManager = $serviceManager->get('ControllerManager');

        /** @var AbstractActionController $controller */
        $controller = $controllerManager->get($controllerName);

        $controller->setEvent($this->event);
        $result = $controller->dispatch($this->event->getRequest());

        if ($result instanceof Response) {
            return $result;
        }

        /** @var DefaultRenderingStrategy $renderingStrategy */
        $renderingStrategy = null;
        foreach (array('HttpDefaultRenderingStrategy', 'DefaultRenderingStrategy') as $serviceName) {
            if ($serviceManager->has($serviceName)) {
                $renderingStrategy = $serviceManager->get($serviceName);
            }
        }

        $this->event->setViewModel($result);

        if ($renderingStrategy instanceof DefaultRenderingStrategy) {
            /** @var ViewModel $result */
            if (!$result->terminate()) {
                $layout = new ViewModel();
                $layoutTemplate = $renderingStrategy->getLayoutTemplate();
                $layout->setTemplate($layoutTemplate);
                $layout->addChild($result);
                $this->event->setViewModel($layout);
            }
        }

        return $renderingStrategy->render($this->event);
    }
}
