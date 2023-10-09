<?php 

# src/EventSubscriber/EasyAdminSubscriber.php
namespace App\EventSubscriber;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{
    // private $slugger;

    // public function __construct($slugger)
    // {
    //     $this->slugger = $slugger;
    // }

    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setVisuals'],
        ];
    }

    public function setVisuals(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Post)) {
            return;
        }

        //$slug = $this->slugger->slugify($entity->getFile());

dd($entity->getFile());
        //$entity->setVisuals($slug);
    }
}