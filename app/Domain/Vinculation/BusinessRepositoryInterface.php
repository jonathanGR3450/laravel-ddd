<?php

declare(strict_types=1);

namespace App\Domain\Vinculation;

use App\Domain\Shared\ValueObjects\Id;
use App\Domain\User\Aggregate\User;
use App\Domain\Vinculation\Aggregate\Business;
use App\Domain\Vinculation\Aggregate\BusinessUser;

interface BusinessRepositoryInterface
{
    public function create(Business $business): void;

    public function createUserBusiness(BusinessUser $businessUser): void;

    public function findById(Id $id): Business;
}