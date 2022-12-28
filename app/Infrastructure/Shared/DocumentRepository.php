<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared;

use App\Domain\Shared\Aggregate\Document;
use App\Domain\Shared\DocumentRepositoryInterface;
use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Description;
use App\Domain\Shared\ValueObjects\Document\TypeProcessId;
use App\Domain\Shared\ValueObjects\Id;
use App\Domain\Shared\ValueObjects\Name;
use App\Infrastructure\Laravel\Models\Document as ModelsDocument;

class DocumentRepository implements DocumentRepositoryInterface
{

    public function findById(Id $id): Document
    {
        $document = ModelsDocument::find($id->value());
        return self::map($document);
    }

    public static function map(ModelsDocument $model): Document
    {
        return Document::create(
            Id::fromPrimitives($model->id),
            Name::fromString($model->name),
            Description::fromString($model->description),
            TypeProcessId::fromPrimitives($model->type_process_id),
            DateTimeValueObject::fromPrimitives($model->created_at->__toString()),
            !empty($model->updated_at) ? DateTimeValueObject::fromPrimitives($model->updated_at->__toString()) : null,
        );
    }
}