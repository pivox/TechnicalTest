<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionHistoricRepository")
 */
class QuestionHistoric
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $oldTitle;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $newTitle;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $oldUpdated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $NewUpdated;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $oldStatus;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $newStatus;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Question")
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getOldTitle():?string
    {
        return $this->oldTitle;
    }

    /**
     * @param mixed $oldTitle
     * @return QuestionHistoric
     */
    public function setOldTitle($oldTitle)
    {
        $this->oldTitle = $oldTitle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewTitle(): ?string
    {
        return $this->newTitle;
    }

    /**
     * @param mixed $newTitle
     * @return QuestionHistoric
     */
    public function setNewTitle($newTitle)
    {
        $this->newTitle = $newTitle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOldUpdated(): ?\DateTime
    {
        return $this->oldUpdated;
    }

    /**
     * @param mixed $oldUpdated
     * @return QuestionHistoric
     */
    public function setOldUpdated($oldUpdated)
    {
        $this->oldUpdated = $oldUpdated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewUpdated(): ?\DateTime
    {
        return $this->NewUpdated;
    }

    /**
     * @param mixed $NewUpdated
     * @return QuestionHistoric
     */
    public function setNewUpdated($NewUpdated)
    {
        $this->NewUpdated = $NewUpdated;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOldStatus(): ?string
    {
        return $this->oldStatus;
    }

    /**
     * @param mixed $oldStatus
     * @return QuestionHistoric
     */
    public function setOldStatus($oldStatus)
    {
        $this->oldStatus = $oldStatus;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNewStatus(): ?string
    {
        return $this->newStatus;
    }

    /**
     * @param mixed $newStatus
     * @return QuestionHistoric
     */
    public function setNewStatus($newStatus)
    {
        $this->newStatus = $newStatus;
        return $this;
    }


    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(?Question $question): self
    {
        $this->question = $question;

        return $this;
    }
}
