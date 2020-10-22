<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;

use App\Application\Command\QuestionCommand;
use App\Domain\Question\Model\Answer;
use App\Domain\Question\Model\Question;
use App\Domain\Question\Port\QuestionRepository;

class CreateQuestionHandler
{

    /** @var QuestionRepository */
    private $questionRepository;

    /**
     * CreateQuestionHandler constructor.
     * @param QuestionRepository $questionRepository
     */
    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function handle(QuestionCommand $questionCommand): Question
    {
        $answers = [];
        foreach ($questionCommand->answers as $answerCommand) {
            $answers[] = new Answer(
                uniqid(),
                $answerCommand->channel,
                $answerCommand->body
            );
        }
        $question = new Question(
            uniqid(),
            $questionCommand->title,
            $questionCommand->promoted,
            $questionCommand->status,
            $answers
        );
        $this->questionRepository->save($question);

        return $question;
    }

}