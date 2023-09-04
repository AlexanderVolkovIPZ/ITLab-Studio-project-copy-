<?php

namespace App\EntityListener;

use App\Entity\ProductHW;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;

class ProductEntityListener
{
    /**
     * @param ProductHW $productHW
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function prePersist(ProductHW $productHW, LifecycleEventArgs $eventArgs): void
    {
        $productHW->setName($productHW->getName()."New");
    }

    /**
     * @param ProductHW $productHW
     * @param PostPersistEventArgs $persistEventArgs
     * @return void
     */
    public function postPersist(ProductHW $productHW, PostPersistEventArgs $persistEventArgs): void
    {

        $test = $persistEventArgs->getObjectManager()->getUnitOfWork()->getEntityChangeSet($productHW);
    }

    /**
     * @param ProductHW $productHW
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function preUpdate(ProductHW $productHW, LifecycleEventArgs $eventArgs): void
    {
        $test = 1;
    }

    /**
     * @param ProductHW $productHW
     * @param LifecycleEventArgs $eventArgs
     * @return void
     */
    public function postUpdate(ProductHW $productHW, LifecycleEventArgs $eventArgs): void
    {
        $test = 1;
    }
}