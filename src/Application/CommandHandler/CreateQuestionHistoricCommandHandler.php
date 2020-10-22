<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;


use App\Application\Command\QuestionHistoricCommand;
use App\Application\Query\DetailQuestion;
use App\Domain\Question\Model\QuestionHistoric;
use App\Domain\Question\Port\QuestionHistoricRepository;

class CreateQuestionHistoricCommandHandler
{

    /** @var QuestionHistoricRepository*/
    private $questionHistoricRepository;

    /** @var DetailQuestion*/
    private $detailQuestion;

    /**
     * CreateQuestionHistoricCommandHandler constructor.
     * @param QuestionHistoricRepository $questionHistoricRepository
     */
    public function __construct(QuestionHistoricRepository $questionHistoricRepository, DetailQuestion $detailQuestion)
    {
        $this->questionHistoricRepository = $questionHistoricRepository;
        $this->detailQuestion = $detailQuestion;
    }

    public function handle(QuestionHistoricCommand $questionHistoricCommand): QuestionHistoric
    {
        $question = $this
            ->detailQuestion
            ->setId($questionHistoricCommand->questionId)
            ->execute()
            ->getQuestion();
        $questionHistoric = new QuestionHistoric(
            $questionHistoricCommand->oldTitle,
            $questionHistoricCommand->newTitle,
            $questionHistoricCommand->oldStatus,
            $questionHistoricCommand->newStatus,
            $questionHistoricCommand->oldUpdated ? $questionHistoricCommand->oldUpdated: null,
            $questionHistoricCommand->newUpdated ? $questionHistoricCommand->newUpdated: null,
            $questionHistoricCommand->oldPromoted,
            $questionHistoricCommand->newPromoted,
            $question
        );
        $this->questionHistoricRepository->save($questionHistoric);

        return $questionHistoric;
    }

}