<?php

declare(strict_types=1);

namespace App\Domain\Question\Port;

use App\Domain\Question\Model\QuestionHistoric;

interface QuestionHistoricRepository
{
    public function save(QuestionHistoric $questionHistoric): void;
}