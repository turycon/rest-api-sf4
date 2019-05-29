<?php
/**
 * Created by PhpStorm.
 * User: gerentent
 * Date: 2019-05-08
 * Time: 13:35
 */

namespace App\EventSubscriber;


use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\RegisterDateEntityInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RegisterDateEntitySubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setDateRegister', EventPriorities::PRE_WRITE]
        ];
    }


    public function setDateRegister(GetResponseForControllerResultEvent $event)
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if(!$entity instanceof RegisterDateEntityInterface || Request::METHOD_POST !== $method){
            return;
        }

        $entity->setCreateDate(new \DateTime('now'));

    }
}