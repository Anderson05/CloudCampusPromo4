<?php

namespace App\Messenger;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use ErrorException;
use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Messenger\MessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

use function PHPUnit\Framework\throwException;

class ContactMessageHandler implements MessageHandlerInterface {

    private $logger;
    private $contact;
    private $em;


    public function __construct(LoggerInterface $logIf, EntityManagerInterface $em){
        $this->logger = $logIf;
        $this->em = $em;
    }

    public function __invoke(ContactMessage $contactMsg)
    {
        $contact_id = $contactMsg->getContactID();
        $this->contact = $this->em->find(Contact::class, $contact_id);
        $this->validerContact($this->contact);
    }


    public function validerContact(Contact $contact){
        throw new ErrorException("Erreur de Test - TPROMO4CC");
        sleep(10);
        $this->logger->info("TPROMO4-CC Async Manager --- ");
        $contact->setStatus(100);
    }

    public function envoyerMail(){
        // Contenu Method complexe en temps
    }

}