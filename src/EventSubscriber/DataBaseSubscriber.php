<?php

namespace App\EventSubscriber;

use App\Controller\TransactionController;
use App\Entity\Transaction;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;

class DataBaseSubscriber implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
        ];
    }

    
    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if ($entity instanceof Transaction) {
            $car = $entity->getCar();
            
            if($car->getStock() == $entity->getValue()) {
                $car->setIsSold(true);
            }
            $car->setStock($car->getStock() - $entity->getValue());
            $manager = $args->getObjectManager();
            $manager->persist($car);
            $manager->flush();
        }
    }
}
