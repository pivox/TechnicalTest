<?php

namespace App\Infrastructure\Persistance\Doctrine\Repository\Question;

use App\Domain\Question\Model\QuestionHistoric;
use App\Domain\Question\Port\QuestionHistoricRepository as QuestionHistoricRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class QuestionHistoricRepository implements QuestionHistoricRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(QuestionHistoric $questionHistoric): void
    {
        $this->entityManager->persist($questionHistoric);
        $this->entityManager->flush();
    }
}
