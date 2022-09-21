<?php

namespace App\Messenger;

use App\Entity\Contact;

class ContactMessage {

    protected $contact_id;
    

    public function __construct(int $contact_id)
    {
        $this->contact_id = $contact_id;
    }

    public function getContactID(){
        return $this->contact_id;
    }

}

