<?php

declare(strict_types=1);

namespace App\Application\Command;

use DateTime;

/**
 * @todo add implement interface
 */
class QuestionHistoricCommand
{
    const NEW_VALUE = 0;
    const OLD_VALUE = 1;

    /**
     * @var string
     */
    public $id;

    /**
     * @var string|null
    */
    public $oldTitle;
    /**
     * @var string|null
    */
    public $newTitle;

    /**
     * @var DateTime|null
     */
    public $oldUpdated;

    /**
     * @var DateTime|null
     */
    public $newUpdated;

    /**
     * @var string|null
     */
    public $oldStatus;

    /**
     * @var string|null
     */
    public $newStatus;

    /**
     * @var boolean|null
     */
    public $oldPromoted;

    /**
     * @var boolean|null
     */
    public $newPromoted;

    /**
     * @var string
     */
    public $questionId;

    /**
     * QuestionHistoricCommand constructor.
     * @param string|null $oldTitle
     * @param string|null $newTitle
     * @param DateTime|null $oldUpdated
     * @param DateTime|null $newUpdated
     * @param string|null $oldStatus
     * @param string|null $newStatus
     * @param bool|null $oldPromoted
     * @param bool|null $newPromoted
     */
    public function __construct(string $id, string $questionId, ?string $oldTitle, ?string $newTitle, ?DateTime $oldUpdated, ?DateTime $newUpdated, ?string $oldStatus, ?string $newStatus, ?bool $oldPromoted, ?bool $newPromoted)
    {
        $this->id = $id;
        $this->questionId = $questionId;
        $this->oldTitle = $oldTitle;
        $this->newTitle = $newTitle;
        $this->oldUpdated = $oldUpdated;
        $this->newUpdated = $newUpdated;
        $this->oldStatus = $oldStatus;
        $this->newStatus = $newStatus;
        $this->oldPromoted = $oldPromoted;
        $this->newPromoted = $newPromoted;
    }


}