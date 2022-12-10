<?php

declare(strict_types=1);

namespace App\Domain\Vinculation;

use App\Domain\Vinculation\Aggregate\TypeProcess;
use App\Domain\Vinculation\Aggregate\Vinculation;

interface VinculationRepositoryInterface
{
    public function create(Vinculation $vinculation): void;
}