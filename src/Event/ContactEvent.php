<?php

namespace App\Event;

use App\Entity\Contact;
use Symfony\Contracts\EventDispatcher\Event;

class ContactEvent extends Event {

    protected $contact;

    public function __construct(Contact $contact)
    {
        // dd($contact);
        $this->contact = $contact;   
    }

    public function getContact(): Contact{
        return $this->contact;
    }

}