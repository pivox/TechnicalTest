<?php

declare(strict_types=1);

namespace App\Application\Query;


use App\Domain\Question\Model\Answer;
use App\Domain\Question\Port\AnswerRepository;

class ListAnswers implements Query
{

    /** @@var AnswerRepository */
    private $answerRepository;

    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;

    }

    /**
     * @return iterable<Answer>
    */
    public function execute(): iterable
    {
        return $this->answerRepository->getAll();
    }
}