<?php

declare(strict_types=1);

namespace App\Domain\Shared;

use App\Domain\Shared\Aggregate\Archive;

interface ArchiveRepositoryInterface
{
    public function create(Archive $archive): void;
}