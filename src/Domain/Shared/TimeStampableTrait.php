<?php

declare(strict_types=1);

namespace App\Domain\Shared;

use DateTime;

trait TimeStampableTrait
{
    /**
     * @var DateTime
     */
    private $created;

    /**
     * @var DateTime
     */
    private $updated;


    public function getCreated(): ?DateTime
    {
        return $this->created;
    }

    public function setCreated(DateTime $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?DateTime
    {
        return $this->updated;
    }

    public function setUpdated(DateTime $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}