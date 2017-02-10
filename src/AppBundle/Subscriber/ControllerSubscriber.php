<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/10/17
 * Time: 12:52 PM
 */

namespace AppBundle\Subscriber;


use AppBundle\Security\SimpleAuthorizer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class ControllerSubscriber implements EventSubscriberInterface
{
    public function onControllerRequest(FilterControllerEvent $event )
    {
        $controller = $event->getController()[0];
        if($controller instanceof SimpleAuthorizer)
        {
            $controller->preMethodCheck();
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.controller' => 'onControllerRequest'
        ];
    }

}