<?php

declare(strict_types=1);

namespace App\Application\Vinculation;

use App\Domain\Shared\State\Pending;
use App\Domain\Shared\TypeProcessRepositoryInterface;
use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Vinculation\Aggregate\Vinculation;
use App\Domain\Vinculation\ValueObjects\BusinessId;
use App\Domain\Vinculation\ValueObjects\Id;
use App\Domain\Vinculation\ValueObjects\State;
use App\Domain\Vinculation\ValueObjects\TypeProcessId;
use App\Domain\Vinculation\ValueObjects\UserId;
use App\Domain\Vinculation\VinculationRepositoryInterface;

final class CreateVinculationUseCase
{
    private VinculationRepositoryInterface $vinculationRepositoryInterface;
    private TypeProcessRepositoryInterface $typeProcessRepositoryInterface;

    public function __construct(VinculationRepositoryInterface $vinculationRepositoryInterface, TypeProcessRepositoryInterface $typeProcessRepositoryInterface) {
        $this->vinculationRepositoryInterface = $vinculationRepositoryInterface;
        $this->typeProcessRepositoryInterface = $typeProcessRepositoryInterface;
    }

    public function __invoke(string $user_id, string $business_id): Vinculation
    {
        $type_process = $this->typeProcessRepositoryInterface->findByName('vinculacion');
        $vinculation = Vinculation::create(
            Id::random(),
            TypeProcessId::fromPrimitives($type_process->id()->value()),
            State::fromString(Pending::class),
            UserId::fromPrimitives($user_id),
            BusinessId::fromPrimitives($business_id),
            DateTimeValueObject::now()
        );

        $this->vinculationRepositoryInterface->create($vinculation);

        return $vinculation;
    }
}