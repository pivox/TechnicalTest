<?php

declare(strict_types=1);

namespace App\Application\Query;


use App\Application\Command\AnswerCommand;
use App\Application\Command\QuestionCommand;
use App\Domain\Question\Model\Answer;
use App\Domain\Question\Model\Question;
use App\Domain\Question\Port\QuestionRepository;

class DetailQuestion implements Query
{

    /** @var string*/
    private $questionId;

    /** @var Question*/
    private $question;

    /** @var QuestionCommand*/
    private $questionCommand;

    /** @@var QuestionRepository */
    private $questionRepository;

    /** @@var DetailAnswer */
    private $detailAnswer;

    public function __construct(QuestionRepository $questionRepository, DetailAnswer $detailAnswer)
    {
        $this->questionRepository = $questionRepository;
        $this->detailAnswer = $detailAnswer;

    }

    /**
     * @return Question
     */
    public function getQuestion(): Question
    {
        return $this->question;
    }

    /**
     * @return QuestionCommand
     */
    public function getQuestionCommand(): QuestionCommand
    {
        return $this->questionCommand;
    }

    /**
     * @todo change return to Command object
    */
    public function execute()
    {
        $this->question = $this->questionRepository->getById($this->questionId);

        if (null === $this->question) {
            return $this;
        }
        $answers = [];
        /** @var Answer $answer*/
        foreach ($this->question->getAnswers() as $answer) {
            $answers[] = $this
                ->detailAnswer
                ->setId($answer->getId())
                ->execute()
                ->getAnswerCommand();
        }

        $this->questionCommand = new QuestionCommand(
            $this->question->getId(),
            $this->question->getTitle(),
            $this->question->getPromoted(),
            $this->question->getStatus(),
            $answers,
            $this->question->getCreated()
        );

        return $this;
    }

    public function setId(string $questionId): self
    {
        $this->questionId = $questionId;

        return $this;
    }
}