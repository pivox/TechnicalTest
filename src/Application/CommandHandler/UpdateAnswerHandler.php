<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\AnswerCommand;
use App\Application\Query\DetailAnswer;
use App\Domain\Question\Port\AnswerRepository;

class UpdateAnswerHandler
{
    /** @var AnswerRepository */
    private $answerRepository;

    /** @var DetailAnswer */
    private $detailAnswer;

    /**
     * CreateAnswerHandler constructor.
     * @param AnswerRepository $answerRepository
     */
    public function __construct(AnswerRepository $answerRepository, DetailAnswer $detailAnswer)
    {
        $this->answerRepository = $answerRepository;
        $this->detailAnswer = $detailAnswer;
    }

    public function handle(AnswerCommand $answerCommand): void
    {
        $answer = $this
            ->detailAnswer
            ->setId($answerCommand->id)
            ->execute()
            ->getAnswer();
        $answer->update(
            $answerCommand->title,
            $answerCommand->promoted,
            $answerCommand->status,
            $answers
        );
        $this->answerRepository->save($answer);
    }

}