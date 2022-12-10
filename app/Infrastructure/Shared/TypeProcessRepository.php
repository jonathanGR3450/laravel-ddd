<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared;

use App\Domain\Shared\Aggregate\TypeProcess;
use App\Domain\Shared\TypeProcessRepositoryInterface;
use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Description;
use App\Domain\Shared\ValueObjects\Id;
use App\Domain\Shared\ValueObjects\Name;
use App\Infrastructure\Laravel\Models\TypeProcess as ModelsTypeProcess;

class TypeProcessRepository implements TypeProcessRepositoryInterface
{

    public function findByName(string $name): TypeProcess
    {
        $typeProcess = ModelsTypeProcess::where('name', $name)->get()->first();
        return self::map($typeProcess);
    }

    public static function map(ModelsTypeProcess $model): TypeProcess
    {
        return TypeProcess::create(
            Id::fromPrimitives($model->id),
            Name::fromString($model->name),
            Description::fromString($model->description),
            DateTimeValueObject::fromPrimitives($model->created_at->__toString()),
            !empty($model->updated_at) ? DateTimeValueObject::fromPrimitives($model->updated_at->__toString()) : null,
        );
    }
}