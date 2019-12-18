<?php

namespace App\EventSubscriber;

use App\Entity\Work;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;

class CreateUrlSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [
            'KernelEvents::READ' => ['updateUrl'],
        ];
    }

    public function updateUrl(ViewEvent $event)
    {
        dd($event);
        $work = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$work instanceof Work || Request::METHOD_POST !== $method) {
            return;
        }

        $message = (new \Swift_Message('A new book has been added'))
            ->setFrom('system@example.com')
            ->setTo('contact@les-tilleuls.coop')
            ->setBody(sprintf('The book #%d has been added.', $book->getId()));

        $this->mailer->send($message);
    }
}
