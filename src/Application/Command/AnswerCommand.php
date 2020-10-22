<?php

declare(strict_types=1);

namespace App\Application\Command;

/**
 * @todo add implement interface
 */
class AnswerCommand
{

    /** @var string */
    public $id;

    /** @var string */
    public $channel;

    /** @var string */
    public $body;

    /** @var QuestionCommand */
    public $question;

    /**
     * AnswerCommand constructor.
     * @param string $id
     * @param string $channel
     * @param string $body
     */
    public function  __construct(string $id, string $channel, string $body)
    {
        $this->id = $id;
        $this->channel = $channel;
        $this->body = $body;
    }
}