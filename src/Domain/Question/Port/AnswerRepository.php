<?php

declare(strict_types=1);

namespace App\Domain\Question\Port;

use App\Domain\Question\Model\Answer;

interface AnswerRepository
{
    public function save(Answer $answer): void;

    public function getById(string $id): ?Answer;

    public function getAll(): iterable;
}