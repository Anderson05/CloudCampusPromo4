<?php

namespace App\EventSubsscriber;

use App\Event\ContactEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ContactSubscriber implements EventSubscriberInterface {

    private $logger;

    public function __construct(LoggerInterface $loggerIf)
    {
        $this->logger = $loggerIf;
    }

    public function onNewContact(ContactEvent $contactEvent){
        $contact = $contactEvent->getContact();
        // dd($contact);
        $msg = sprintf("PROMO4-LOGGER : EVENT NEW CONTACT [%s - %s] ------- ", $contact->getName(), $contact->getEmail());
        // var_dump($msg);
        $this->logger->info($msg);
    }

    public static function getSubscribedEvents(){
        return [
            ContactEvent::class => ['onNewContact',1]
        ];
    }

}