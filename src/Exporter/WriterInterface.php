<?php

namespace App\Exporter;

interface WriterInterface
{
    public function write(array $data);
}