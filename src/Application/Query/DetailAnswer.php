<?php

declare(strict_types=1);

namespace App\Application\Query;


use App\Application\Command\AnswerCommand;
use App\Domain\Question\Model\Answer;
use App\Domain\Question\Port\AnswerRepository;

class DetailAnswer implements Query
{

    /** @var string */
    private $answerId;

    /** @var Answer */
    private $answer;

    /** @var AnswerCommand */
    private $answerCommand;

    /** @@var AnswerRepository */
    private $answerRepository;

    public function __construct(AnswerRepository $answerRepository)
    {
        $this->answerRepository = $answerRepository;
    }

    /**
     * @return Answer
     */
    public function getAnswer(): Answer
    {
        return $this->answer;
    }

    /**
     * @return AnswerCommand
     */
    public function getAnswerCommand(): AnswerCommand
    {
        return $this->answerCommand;
    }

    public function setId(string $answerId): self
    {
        $this->answerId = $answerId;

        return $this;
    }

    /**
     * @todo change return to Command object
     */
    public function execute()
    {
        $this->answer = $this->answerRepository->getById($this->answerId);
        if (null === $this->answer) {
            return $this;
        }
        $this->answerCommand = new AnswerCommand(
            $this->answer->getId(),
            $this->answer->getChannel(),
            $this->answer->getBody(),
        );
        return $this;
    }
}