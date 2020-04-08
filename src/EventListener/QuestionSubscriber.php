<?php

namespace App\EventListener;

use App\Entity\QuestionHistoric;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

/**
 * Class QuestionSubscriber
 * @package App\EventListener
 */
class QuestionSubscriber implements EventSubscriber
{
    /**
     * @return array|string[]
     */
    public function getSubscribedEvents()
    {
        return array(
            Events::postUpdate,
        );
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postUpdate(LifecycleEventArgs  $args)
    {
        if($this->haveToPersistQuestionHistoric($args)) {
            $questionHistoric = new QuestionHistoric();
            $questionHistoric = $this->setTitle($questionHistoric, $args);
            $questionHistoric = $this->setUpdated($questionHistoric, $args);
            $questionHistoric = $this->setStatus($questionHistoric, $args);
            $questionHistoric->setQuestion($args->getObject());
            $args->getEntityManager()->persist($questionHistoric);
            $args->getEntityManager()->flush($questionHistoric);
        }
    }

    /**
     * @param QuestionHistoric $questionHistoric
     * @param \Doctrine\ORM\Event\LifecycleEventArgs $args
     * @param $value
     * @return QuestionHistoric
     */
    private function setValue(QuestionHistoric $questionHistoric, LifecycleEventArgs $args, $value)
    {
        $unit = $args->getEntityManager()->getUnitOfWork();
        $entityChangeSet = $unit->getEntityChangeSet($args->getObject());
        if(array_key_exists($value, $entityChangeSet)  && $entityChangeSet[$value][0] != $entityChangeSet[$value][1]) {
            $questionHistoric
                ->{'setNew'.ucfirst($value)}($entityChangeSet[$value][1])
                ->{'setOld'.ucfirst($value)}($entityChangeSet[$value][0]);
        }
        return $questionHistoric;
    }

    /**
     * @param QuestionHistoric $questionHistoric
     * @param LifecycleEventArgs $args
     * @return QuestionHistoric
     */
    private function setUpdated(QuestionHistoric $questionHistoric, LifecycleEventArgs $args)
    {
        return $this->setValue($questionHistoric, $args, 'updated');
    }

    /**
     * @param QuestionHistoric $questionHistoric
     * @param LifecycleEventArgs $args
     * @return QuestionHistoric
     */
    private function setStatus(QuestionHistoric $questionHistoric, LifecycleEventArgs $args)
    {
        return $this->setValue($questionHistoric, $args, 'status');
    }

    /**
     * @param QuestionHistoric $questionHistoric
     * @param LifecycleEventArgs $args
     * @return QuestionHistoric
     */
    private function setTitle(QuestionHistoric $questionHistoric, LifecycleEventArgs $args)
    {
        return $this->setValue($questionHistoric, $args, 'title');
    }


    /**
     * @param LifecycleEventArgs $args
     * @return bool
     */
    private function haveToPersistQuestionHistoric(LifecycleEventArgs $args)
    {
        $unit = $args->getEntityManager()->getUnitOfWork();
        $entityChangeSet = $unit->getEntityChangeSet($args->getObject());
        return array_key_exists('status', $entityChangeSet) ||
            array_key_exists('title', $entityChangeSet) ||
            array_key_exists('updated', $entityChangeSet);
    }
}