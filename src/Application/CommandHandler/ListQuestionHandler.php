<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;


use App\Application\Query\ListQuestions;

class ListQuestionHandler
{

    /** @var ListQuestions*/
    private $listQuestions;

    /**
     * ListQuestionHandler constructor.
     * @param ListQuestions $listQuestions
     */
    public function __construct(ListQuestions $listQuestions)
    {
        $this->listQuestions = $listQuestions;
    }


    public function handle(): iterable
    {
        return $this->listQuestions->execute()->getQuestionCommands();
    }
}