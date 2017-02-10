<?php
/**
 * Created by PhpStorm.
 * User: mbyrnes
 * Date: 2/8/17
 * Time: 12:53 PM
 */

namespace AppBundle\Subscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class UserAgentSubscriber implements EventSubscriberInterface
{
    public function onKernelRequest( GetResponseEvent $event )
    {
        $request = $event->getRequest();
        $userAgent = $request
            ->headers->get('User-Agent');
        $request->attributes->set('userAgent', $userAgent);
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest'
        ];
    }

}