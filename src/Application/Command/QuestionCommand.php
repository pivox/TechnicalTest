<?php

declare(strict_types=1);

namespace App\Application\Command;

use DateTime;

/**
 * @todo add implement interface
 */
class QuestionCommand
{
    /** @var string */
    public $id;

    /** @var string */
    public $title;

    /** @var boolean */
    public $promoted;

    /** @var string */
    public $status;

    /** @var iterable<AnswerCommand>|null */
    public $answers;

    /**
     * @var DateTime
     */
    public $created;

    /**
     * QuestionCommand constructor.
     * @param string $id
     * @param string $title
     * @param bool $promoted
     * @param string $status
     * @param iterable<AnswerCommand> $answers
     */
    public function __construct(string $id, string $title, bool $promoted, string $status, ?iterable $answers, ?DateTime $created = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->promoted = $promoted;
        $this->status = $status;
        $this->answers = $answers;
        $this->created = $created;
    }
}