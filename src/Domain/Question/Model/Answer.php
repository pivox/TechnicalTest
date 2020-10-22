<?php

declare(strict_types=1);

namespace App\Domain\Question\Model;

class Answer
{
    const CHANNEL_FAQ = 'faq';
    const CHANNEL_BOT = 'bot';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var string
     */
    private $body;

    /**
     * @var Question
     */
    private $question;

    /**
     * Answer constructor.
     * @param string $id
     * @param string $channel
     * @param string $body
     * @param Question $question
     */
    public function __construct(string $id, string $channel, string $body)
    {
        $this->id = $id;
        $this->update($channel, $body);
    }

    public function update(string $channel, string $body)
    {
        $this->channel = $channel;
        $this->body = $body;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getChannel(): string
    {
        return $this->channel;
    }

    public function setChannel(string $channel): self
    {
        $this->channel = $channel;

        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getQuestion(): Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
