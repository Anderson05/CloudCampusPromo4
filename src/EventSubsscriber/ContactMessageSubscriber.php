<?php

namespace App\EventSubsscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Messenger\Event\WorkerMessageFailedEvent;

class ContactMessageSubscriber implements EventSubscriberInterface {
    
    public static function getSubscribedEvents(){
        return [
            WorkerMessageFailedEvent::class => 'onMessageFailed'
        ];
    }

    public function onMessageFailed(WorkerMessageFailedEvent $failedMessageEvt){
        $messageFailed = $failedMessageEvt->getEnvelope()->getMessage();
        dd($messageFailed);
    }
}