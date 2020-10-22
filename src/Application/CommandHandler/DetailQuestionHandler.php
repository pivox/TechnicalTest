<?php

declare(strict_types=1);

namespace App\Application\CommandHandler;


use App\Application\Command\QuestionCommand;
use App\Application\Query\DetailQuestion;

class DetailQuestionHandler
{
    /** @var DetailQuestion */
    private $query;

    /**
     * DetailQuestionController constructor.
     * @param DetailQuestion $query
     */
    public function __construct(DetailQuestion $query)
    {
        $this->query = $query;
    }

    public function handle(string $id): QuestionCommand
    {
        return $this->query->setId($id)->execute()->getQuestionCommand();
    }
}