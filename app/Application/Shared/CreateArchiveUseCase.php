<?php

declare(strict_types=1);

namespace App\Application\Shared;

use App\Application\Auth\Contracts\AuthUserInterface;
use App\Domain\Shared\Aggregate\Archive;
use App\Domain\Shared\Aggregate\Document;
use App\Domain\Shared\ArchiveRepositoryInterface;
use App\Domain\Shared\DocumentRepositoryInterface;
use App\Domain\Shared\TypeProcessRepositoryInterface;
use App\Domain\Shared\ValueObjects\Archive\DocumentId;
use App\Domain\Shared\ValueObjects\Archive\NameNow;
use App\Domain\Shared\ValueObjects\Archive\NamePrevious;
use App\Domain\Shared\ValueObjects\Archive\Path;
use App\Domain\Shared\ValueObjects\Archive\ProcessId;
use App\Domain\Shared\ValueObjects\Archive\TypeArchive;
use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Id;
use App\Domain\Vinculation\Aggregate\Business;
use App\Domain\Vinculation\Aggregate\Vinculation;
use App\Domain\Vinculation\VinculationRepositoryInterface;

final class CreateArchiveUseCase
{
    private ArchiveRepositoryInterface $archiveRepositoryInterface;
    private TypeProcessRepositoryInterface $typeProcessRepositoryInterface;
    private DocumentRepositoryInterface $documentRepositoryInterface;
    private VinculationRepositoryInterface $vinculationRepositoryInterface;
    private AuthUserInterface $authUserInterface;

    public function __construct(
            ArchiveRepositoryInterface $archiveRepositoryInterface,
            TypeProcessRepositoryInterface $typeProcessRepositoryInterface,
            DocumentRepositoryInterface $documentRepositoryInterface,
            VinculationRepositoryInterface $vinculationRepositoryInterface,
            AuthUserInterface $authUserInterface,
        ) {
        $this->archiveRepositoryInterface = $archiveRepositoryInterface;
        $this->typeProcessRepositoryInterface = $typeProcessRepositoryInterface;
        $this->documentRepositoryInterface = $documentRepositoryInterface;
        $this->vinculationRepositoryInterface = $vinculationRepositoryInterface;
        $this->authUserInterface = $authUserInterface;
    }

    public function __invoke(
        string $document_id,
        string $type_archive,
        string $path,
        string $name_previous,
        string $extension,
        string $business_id,
        \Illuminate\Http\UploadedFile $file,
        string $typeProcess,
    ): Archive
    {
        $typeProcess = $this->typeProcessRepositoryInterface->findByName($typeProcess);
        $document = $this->documentRepositoryInterface->findById(Id::fromPrimitives($document_id));
        $business = $this->authUserInterface->getBusinessById($business_id);
        $name_now = Archive::generateName($document, $business, $extension);
        $vinculation = $this->vinculationRepositoryInterface->findByBusinessTypeProcess($typeProcess, $business);

        $archive = Archive::create(
            Id::random(),
            DocumentId::fromPrimitives($document->id()->value()),
            TypeArchive::fromString($type_archive),
            Path::fromString($path),
            NameNow::fromString($name_now),
            NamePrevious::fromString($name_previous),
            ProcessId::fromPrimitives($vinculation->id()->value()),
            DateTimeValueObject::now()
        );

        $archive->saveFile($file);

        $this->archiveRepositoryInterface->create($archive);

        return $archive;
    }
}