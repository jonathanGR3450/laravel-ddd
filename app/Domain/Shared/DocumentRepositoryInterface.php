<?php

declare(strict_types=1);

namespace App\Domain\Shared;

use App\Domain\Shared\Aggregate\Document;
use App\Domain\Shared\ValueObjects\Id;

interface DocumentRepositoryInterface
{
    public function findById(Id $id): Document;
}