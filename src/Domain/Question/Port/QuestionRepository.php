<?php

declare(strict_types=1);

namespace App\Domain\Question\Port;

use App\Domain\Question\Model\Question;

interface QuestionRepository
{
    public function save(Question $question): void;

    public function getById(string $id): ?Question;

    public function getAll(): iterable;
}