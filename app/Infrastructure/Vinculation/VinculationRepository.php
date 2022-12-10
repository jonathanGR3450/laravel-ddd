<?php

declare(strict_types=1);

namespace App\Infrastructure\Vinculation;

use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Vinculation\Aggregate\Vinculation;
use App\Domain\Vinculation\ValueObjects\BusinessId;
use App\Domain\Vinculation\ValueObjects\Id;
use App\Domain\Vinculation\ValueObjects\State;
use App\Domain\Vinculation\ValueObjects\TypeProcessId;
use App\Domain\Vinculation\ValueObjects\UserId;
use App\Domain\Vinculation\VinculationRepositoryInterface;
use App\Infrastructure\Laravel\Models\Vinculation\Process;

class VinculationRepository implements VinculationRepositoryInterface
{

    public function create(Vinculation $vinculation): void
    {
        $processModel = new Process();

        $processModel->id = $vinculation->id()->value();
        $processModel->type_process_id = $vinculation->typeProcessId()->value();
        $processModel->state = $vinculation->state()->value();
        $processModel->user_id = $vinculation->userId()->value();
        $processModel->business_id = $vinculation->businessId()->value();
        $processModel->created_at = DateTimeValueObject::now()->value();

        $processModel->save();
    }

    public static function map(Process $model): Vinculation
    {
        return Vinculation::create(
            Id::fromPrimitives($model->id),
            TypeProcessId::fromPrimitives($model->type_process_id),
            State::fromString($model->state::class),
            UserId::fromPrimitives($model->user_id),
            BusinessId::fromPrimitives($model->business_id),
            DateTimeValueObject::fromPrimitives($model->created_at->__toString()),
            !empty($model->updated_at) ? DateTimeValueObject::fromPrimitives($model->updated_at->__toString()) : null,
        );
    }
}