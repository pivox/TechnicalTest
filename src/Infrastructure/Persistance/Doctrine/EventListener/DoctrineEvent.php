<?php
declare(strict_types=1);


namespace App\Infrastructure\Doctrine\EventListener;

use App\Application\Command\QuestionHistoricCommand;
use App\Application\CommandHandler\CreateQuestionHistoricCommandHandler;
use App\Domain\Question\Model\Question;
use App\Domain\Question\Model\QuestionHistoric;
use App\Domain\Shared\TimeStampable;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

use DateTime;

class DoctrineEvent implements EventSubscriber
{
    /**
     * @var CreateQuestionHistoricCommandHandler
    */
    private $createQuestionHistoricCommandHandler;

    /**
     * DoctrineEvent constructor.
     * @param CreateQuestionHistoricCommandHandler $createQuestionHistoricCommandHandler
     */
    public function __construct(CreateQuestionHistoricCommandHandler $createQuestionHistoricCommandHandler)
    {
        $this->createQuestionHistoricCommandHandler = $createQuestionHistoricCommandHandler;
    }


    /**
     * @inheritDoc
     */
    public function getSubscribedEvents()
    {
        return [Events::prePersist, Events::preUpdate, Events::postUpdate];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
//        dump(__LINE__.'');die;
        $object = $args->getObject();
        if ($object instanceof TimeStampable) {
            $object->setUpdated(new DateTime());
            if (null === $object->getCreated()) {
                $object->setCreated(new DateTime());
            }
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $object = $args->getObject();
        if ($object instanceof TimeStampable) {
            $object->setUpdated(new DateTime());
        }

    }

    public function postUpdate(LifecycleEventArgs $args)
    {
//        dump('postUpdate >');die;
        if($this->haveToPersistQuestionHistoric($args) && $args->getObject() instanceof Question) {
//            dump($args->getObject(), $args->getObject()->getId());die;
            $command = new QuestionHistoricCommand(
                uniqid(),
                $args->getObject()->getId(),
                $this->getTitle($args, QuestionHistoricCommand::OLD_VALUE),
                $this->getTitle($args, QuestionHistoricCommand::NEW_VALUE),
                $this->getUpdated($args, QuestionHistoricCommand::OLD_VALUE),
                $this->getUpdated($args, QuestionHistoricCommand::NEW_VALUE),
                $this->getStatus($args, QuestionHistoricCommand::OLD_VALUE),
                $this->getStatus($args, QuestionHistoricCommand::NEW_VALUE),
                $this->getPromoted($args, QuestionHistoricCommand::OLD_VALUE),
                $this->getPromoted($args, QuestionHistoricCommand::NEW_VALUE),
            );
            $this->createQuestionHistoricCommandHandler->handle($command);
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @param $value
     * @return mixed
     */
    private function getValue(LifecycleEventArgs $args, int $order, $value)
    {
        $unit = $args->getEntityManager()->getUnitOfWork();
        $entityChangeSet = $unit->getEntityChangeSet($args->getObject());
        if(array_key_exists($value, $entityChangeSet)  && $entityChangeSet[$value][0] != $entityChangeSet[$value][1]) {
            return $entityChangeSet[$value][$order];
        }
        
        return null;
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function getPromoted(LifecycleEventArgs $args, int $order)
    {
        return $this->getValue($args, $order, 'promoted');
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function getUpdated(LifecycleEventArgs $args, int $order)
    {
        return $this->getValue($args, $order, 'updated');
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function getStatus(LifecycleEventArgs $args, int $order)
    {
        return $this->getValue($args, $order, 'status');
    }

    /**
     * @param LifecycleEventArgs $args
     */
    private function getTitle(LifecycleEventArgs $args, int $order)
    {
        return $this->getValue($args, $order,  'title');
    }


    /**
     * @param LifecycleEventArgs $args
     * @return bool
     */
    private function haveToPersistQuestionHistoric(LifecycleEventArgs $args)
    {
        $unit = $args->getObjectManager()->getUnitOfWork();
        $entityChangeSet = $unit->getEntityChangeSet($args->getObject());
        return array_key_exists('status', $entityChangeSet) ||
            array_key_exists('title', $entityChangeSet) ||
            array_key_exists('updated', $entityChangeSet);
    }
}