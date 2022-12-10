<?php

declare(strict_types=1);

namespace App\Domain\Shared;

use App\Domain\Shared\Aggregate\TypeProcess;

interface TypeProcessRepositoryInterface
{
    public function findByName(string $name): TypeProcess;
}