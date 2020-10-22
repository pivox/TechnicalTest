<?php

declare(strict_types=1);

namespace App\Domain\Question\Model;

use App\Domain\Shared\TimeStampable;
use App\Domain\Shared\TimeStampableTrait;

class Question implements TimeStampable
{
    use TimeStampableTrait;

    const STATUS_DRAFT = 'draft';
    const STATUS_PUBLISHED = 'published';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var boolean
     */
    private $promoted;

    /**
     * @var string
     */
    private $status;

    /**
     * @var iterable<Answer>|null
     */
    private $answers;

    /**
     * Question constructor.
     * @param string $id
     * @param string $title
     * @param bool $promoted
     * @param string $status
     * @param iterable<Answer>|null $answers
     */
    public function __construct(?string $id, string $title, bool $promoted, string $status, ?iterable $answers = null)
    {
        $this->id = null === $id ? uniqid(): $id;
        $this->update($title, $promoted, $status, $answers);
    }

    public function update(string $title, bool $promoted, string $status, ?iterable $answers = null): void
    {
        $this->title = $title;
        $this->promoted = $promoted;
        $this->status = $status;
        if (null !== $answers) {
            $this->setAnswers($answers);
        }
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPromoted(): ?bool
    {
        return $this->promoted;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return iterable|null
     */
    public function getAnswers(): ?iterable
    {
        return $this->answers;
    }

    /**
     * @param iterable<Answer>|null $answers
     * @return Question
     */
    public function setAnswers(?iterable $answers): Question
    {
        $this->answers = $answers;
//        if(is_iterable($answers)) {
//            foreach ($answers as $answer) {
//                $answer->setQuestion($this);
//                $this->answers[] = $answer;
//            }
//        }
        return $this;
    }
}
