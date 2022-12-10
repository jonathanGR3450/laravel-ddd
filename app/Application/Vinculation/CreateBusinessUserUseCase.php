<?php

declare(strict_types=1);

namespace App\Application\Vinculation;

use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\User\Aggregate\User;
use App\Domain\Vinculation\Aggregate\Business;
use App\Domain\Vinculation\Aggregate\BusinessUser;
use App\Domain\Vinculation\BusinessRepositoryInterface;
use App\Domain\Vinculation\ValueObjects\BusinessId;
use App\Domain\Vinculation\ValueObjects\Id;
use App\Domain\Vinculation\ValueObjects\UserId;

final class CreateBusinessUserUseCase
{
    private BusinessRepositoryInterface $businessRepositoryInterface;

    public function __construct(BusinessRepositoryInterface $businessRepositoryInterface) {
        $this->businessRepositoryInterface = $businessRepositoryInterface;
    }

    public function __invoke(Business $business, User $user): BusinessUser
    {
        $businessUser = BusinessUser::create(
            Id::random(),
            BusinessId::fromPrimitives($business->id()->value()),
            UserId::fromPrimitives($user->id()->value()),
            DateTimeValueObject::now()
        );

        $this->businessRepositoryInterface->createUserBusiness($businessUser);

        return $businessUser;
    }
}