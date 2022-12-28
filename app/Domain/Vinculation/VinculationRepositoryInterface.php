<?php

declare(strict_types=1);

namespace App\Domain\Vinculation;

use App\Domain\Shared\Aggregate\TypeProcess;
use App\Domain\Vinculation\Aggregate\Business;
use App\Domain\Vinculation\Aggregate\Vinculation;

interface VinculationRepositoryInterface
{
    public function create(Vinculation $vinculation): void;

    public function findByBusinessTypeProcess(TypeProcess $typeProcess, Business $business): Vinculation;
}