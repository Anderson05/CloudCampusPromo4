<?php 

namespace App\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Entity\Contact;

class ContactListener {

    public function prePersist(LifecycleEventArgs $args):void{

        $entity = $args->getEntity();
        if ($entity instanceof Contact){
            $entity->setCreatedAt(new \DateTimeImmutable());
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
        // dd($entity);
    }

    public function postPersist(LifecycleEventArgs $args):void{

        $entity = $args->getEntity();
        // if ($entity instanceof Contact)
        print("Post Persist : ");
        // dd($entity);
    }

    public function preUpdate(LifecycleEventArgs $args):void{

        $entity = $args->getEntity();
        if ($entity instanceof Contact){
            $entity->setUpdatedAt(new \DateTimeImmutable());
        }
        // dd($entity);
    }
}