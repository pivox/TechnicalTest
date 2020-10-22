<?php

namespace App\Infrastructure\Persistance\Doctrine\Repository\Question;


use App\Domain\Question\Model\Question;
use App\Domain\Question\Port\QuestionRepository as QuestionRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class QuestionRepository implements QuestionRepositoryInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function save(Question $question): void
    {
        $this->entityManager->persist($question);
        $this->entityManager->flush();
    }

    public function getById(string $id): ?Question
    {
        return $this
            ->entityManager
            ->createQuery('
                SELECT question, answers
                FROM App\Domain\Question\Model\Question question
                lEFT JOIN  question.answers answers 
                WHERE question.id = :id 
            ')
            ->setParameter('id', $id)
            ->getOneOrNullResult();
    }

    public function getAll(): iterable
    {
        return $this
            ->entityManager
            ->createQueryBuilder()
            ->select('question')
            ->from(Question::class, 'question')
            ->getQuery()
            ->getResult();
    }
}
