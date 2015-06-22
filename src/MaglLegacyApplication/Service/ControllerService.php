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
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use MaglLegacyApplication\Application\MaglLegacy;

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

    public function __construct(EventManager $eventManager, MvcEvent $event, RouteMatch $routeMatch)
    {
        $this->eventManager = $eventManager;
        $this->event = $event;
        $this->routeMatch = $routeMatch;
    }

    public function runControllerAction($controllerName, $action, $params = array())
    {

        $this->routeMatch->setParam('controller', $controllerName);
        $this->routeMatch->setParam('action', $action);

        foreach ($params as $key => $value) {
            $this->routeMatch->setParam($key, $value);

        }
        $this->event->setRouteMatch($this->routeMatch);
        $this->eventManager->trigger(MvcEvent::EVENT_DISPATCH, $this->event);
        $result = $this->event->getResult();

        $this->eventManager->getSharedManager()->attach('*', MaglLegacy::EVENT_SHORT_CIRCUIT_RESPONSE, function (Event $e) use ($result) {
            $e->stopPropagation(true);
            return $result;
        });
    }

}