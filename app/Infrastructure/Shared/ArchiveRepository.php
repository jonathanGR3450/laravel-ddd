<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared;

use App\Domain\Shared\Aggregate\Archive;
use App\Domain\Shared\ArchiveRepositoryInterface;
use App\Domain\Shared\ValueObjects\Archive\DocumentId;
use App\Domain\Shared\ValueObjects\Archive\NameNow;
use App\Domain\Shared\ValueObjects\Archive\NamePrevious;
use App\Domain\Shared\ValueObjects\Archive\Path;
use App\Domain\Shared\ValueObjects\Archive\ProcessId;
use App\Domain\Shared\ValueObjects\Archive\TypeArchive;
use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Id;
use App\Infrastructure\Laravel\Models\Archive as VinculationArchive;

class ArchiveRepository implements ArchiveRepositoryInterface
{

    public function create(Archive $archive): void
    {
        $archiveModel = new VinculationArchive();

        $archiveModel->id = $archive->id()->value();
        $archiveModel->document_id = $archive->documentId()->value();
        $archiveModel->type_archive = $archive->typeArchive()->value();
        $archiveModel->path = $archive->path()->value();
        $archiveModel->name_now = $archive->nameNow()->value();
        $archiveModel->name_previous = $archive->namePrevious()->value();
        $archiveModel->process_id = $archive->processId()->value();

        $archiveModel->save();
    }

    public static function map(VinculationArchive $model): Archive
    {
        return Archive::create(
            Id::fromPrimitives($model->id),
            DocumentId::fromPrimitives($model->document_id),
            TypeArchive::fromString($model->type_archive),
            Path::fromString($model->path),
            NameNow::fromString($model->name_now),
            NamePrevious::fromString($model->name_previous),
            ProcessId::fromPrimitives($model->process_id),
            DateTimeValueObject::fromPrimitives($model->created_at->__toString()),
            !empty($model->updated_at) ? DateTimeValueObject::fromPrimitives($model->updated_at->__toString()) : null,
        );
    }
}