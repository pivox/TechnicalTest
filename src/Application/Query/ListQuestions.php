<?php

declare(strict_types=1);

namespace App\Application\Query;


use App\Application\Command\QuestionCommand;
use App\Domain\Question\Model\Question;
use App\Domain\Question\Port\QuestionRepository;

class ListQuestions implements Query
{

    /** @@var QuestionRepository*/
    private $questionRepository;

    /** @var iterable<Question>*/
    private $questions;

    /** @var iterable<QuestionCommand>*/
    private $questionCommands;

    /** @@var DetailAnswer */
    private $detailAnswer;

    public function __construct(QuestionRepository $questionRepository, DetailAnswer $detailAnswer)
    {
        $this->questionRepository = $questionRepository;
        $this->detailAnswer = $detailAnswer;

    }

    public function execute()
    {
        $this->questions = $this->questionRepository->getAll();
        foreach ($this->questions as $question) {
            $answers = [];
            /** @var Answer $answer*/
            foreach ($question->getAnswers() as $answer) {
                $answers[] = $this
                    ->detailAnswer
                    ->setId($answer->getId())
                    ->execute()
                    ->getAnswerCommand();
            }
            $this->questionCommands[] = new QuestionCommand(
                $question->getId(),
                $question->getTitle(),
                $question->getPromoted(),
                $question->getStatus(),
                $answers,
                $question->getCreated()
            );
        }

        return $this;
    }

    /**
     * @return iterable
     */
    public function getQuestions(): iterable
    {
        return $this->questions;
    }

    /**
     * @return iterable
     */
    public function getQuestionCommands(): iterable
    {
        return $this->questionCommands;
    }

}