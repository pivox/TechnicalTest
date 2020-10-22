<?php

namespace App\Infrastructure\Persistance\Doctrine\Repository\Question;

use App\Domain\Question\Model\Answer;
use App\Domain\Question\Port\AnswerRepository as AnswerRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class AnswerRepository implements AnswerRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(Answer $answer): void
    {
        $this->entityManager->persist($answer);
        $this->entityManager->flush();
    }
    public function getById(string $id): ?Answer
    {
        return $this
            ->entityManager
            ->createQuery('
                SELECT answer
                FROM App\Domain\Question\Model\Answer answer
                WHERE answer.id = :id 
            ')
            ->setParameter('id', $id)
            ->getOneOrNullResult();
    }

    public function getAll(): iterable
    {
        return $this
            ->entityManager
            ->getRepository(Answer::class)
            ->findAll();
    }
}
