<?php

declare(strict_types=1);

namespace App\Domain\Question\Model;


class QuestionHistoric
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string|null
     */
    private $oldTitle;

    /**
     * @var string|null
     */
    private $newTitle;

    /**
     * @var \DateTime|null
     */
    private $oldUpdated;

    /**
     * @var \DateTime|null
     */
    private $newUpdated;

    /**
     * @var string|null
     */
    private $oldStatus;

    /**
     * @var string|null
     */
    private $newStatus;

    /**
     * @var boolean|null
     */
    private $oldPromoted;

    /**
     * @var boolean|null
     */
    private $newPromoted;

    /**
     * @var Question|null
     */
    private $question;

    /**
     * QuestionHistoric constructor.
     * @param string $id
     * @param string|null $oldTitle
     * @param string|null $newTitle
     * @param \DateTime|null $oldUpdated
     * @param \DateTime|null $newUpdated
     * @param string|null $oldStatus
     * @param string|null $newStatus
     * @param Question|null $question
     */
    public function __construct(
        ?string $oldTitle,
        ?string $newTitle,
        ?string $oldStatus,
        ?string $newStatus,
        ?\DateTime $oldUpdated,
        ?\DateTime $newUpdated,
        ?bool $newPromoted,
        ?bool $oldPromoted,
        ?Question $question
    )
    {
        $this->id = uniqid();
        $this->oldTitle = $oldTitle;
        $this->newTitle = $newTitle;
        $this->oldUpdated = $oldUpdated;
        $this->newUpdated = $newUpdated;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->oldPromoted = $oldPromoted;
        $this->newPromoted = $newPromoted;
        $this->question = $question;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getOldTitle(): ?string
    {
        return $this->oldTitle;
    }

    /**
     * @param string|null $oldTitle
     * @return QuestionHistoric
     */
    public function setOldTitle(?string $oldTitle): QuestionHistoric
    {
        $this->oldTitle = $oldTitle;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNewTitle(): ?string
    {
        return $this->newTitle;
    }

    /**
     * @param string|null $newTitle
     * @return QuestionHistoric
     */
    public function setNewTitle(?string $newTitle): QuestionHistoric
    {
        $this->newTitle = $newTitle;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getOldUpdated(): ?\DateTime
    {
        return $this->oldUpdated;
    }

    /**
     * @param \DateTime|null $oldUpdated
     * @return QuestionHistoric
     */
    public function setOldUpdated(?\DateTime $oldUpdated): QuestionHistoric
    {
        $this->oldUpdated = $oldUpdated;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getNewUpdated(): ?\DateTime
    {
        return $this->newUpdated;
    }

    /**
     * @param \DateTime|null $newUpdated
     * @return QuestionHistoric
     */
    public function setNewUpdated(?\DateTime $newUpdated): QuestionHistoric
    {
        $this->newUpdated = $newUpdated;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOldStatus(): ?string
    {
        return $this->oldStatus;
    }

    /**
     * @param string|null $oldStatus
     * @return QuestionHistoric
     */
    public function setOldStatus(?string $oldStatus): QuestionHistoric
    {
        $this->oldStatus = $oldStatus;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getNewStatus(): ?string
    {
        return $this->newStatus;
    }

    /**
     * @param string|null $newStatus
     * @return QuestionHistoric
     */
    public function setNewStatus(?string $newStatus): QuestionHistoric
    {
        $this->newStatus = $newStatus;
        return $this;
    }

    /**
     * @return Question|null
     */
    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    /**
     * @param Question|null $question
     * @return QuestionHistoric
     */
    public function setQuestion(?Question $question): QuestionHistoric
    {
        $this->question = $question;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getOldPromoted(): ?bool
    {
        return $this->oldPromoted;
    }

    /**
     * @param bool|null $oldPromoted
     * @return QuestionHistoric
     */
    public function setOldPromoted(?bool $oldPromoted): QuestionHistoric
    {
        $this->oldPromoted = $oldPromoted;
        return $this;
    }

    /**
     * @return bool|null
     */
    public function getNewPromoted(): ?bool
    {
        return $this->newPromoted;
    }

    /**
     * @param bool|null $newPromoted
     * @return QuestionHistoric
     */
    public function setNewPromoted(?bool $newPromoted): QuestionHistoric
    {
        $this->newPromoted = $newPromoted;
        return $this;
    }
}
