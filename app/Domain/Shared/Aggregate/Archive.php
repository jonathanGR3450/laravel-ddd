<?php

declare(strict_types=1);

namespace App\Domain\Shared\Aggregate;

use App\Domain\Shared\ValueObjects\Archive\DocumentId;
use App\Domain\Shared\ValueObjects\Archive\NameNow;
use App\Domain\Shared\ValueObjects\Archive\NamePrevious;
use App\Domain\Shared\ValueObjects\Archive\Path;
use App\Domain\Shared\ValueObjects\Archive\ProcessId;
use App\Domain\Shared\ValueObjects\Archive\TypeArchive;
use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Id;
use App\Domain\User\ValueObjects\TypeDocumentId;
use App\Domain\Vinculation\Aggregate\Business;
use Illuminate\Support\Facades\Storage;

final class Archive
{
    private function __construct(
        private Id $id,
        private DocumentId $documentId,
        private TypeArchive $typeArchive,
        private Path $path,
        private NameNow $nameNow,
        private NamePrevious $namePrevious,
        private ProcessId $processId,
        private DateTimeValueObject $created_at,
        private ?DateTimeValueObject $updated_at
    ) {
    }

    public static function create(
        Id $id,
        DocumentId $documentId,
        TypeArchive $typeArchive,
        Path $path,
        NameNow $nameNow,
        NamePrevious $namePrevious,
        ProcessId $processId,
        DateTimeValueObject $created_at,
        ?DateTimeValueObject $updated_at = null
    ): self {
        return new self(
            $id,
            $documentId,
            $typeArchive,
            $path,
            $nameNow,
            $namePrevious,
            $processId,
            $created_at,
            $updated_at
        );
    }

    public static function generateName(Document $document, Business $business, string $extension): string
    {
        return $business->id()->value() . '_' . date('Y-m-d-h-s') . '_' . $document->name()->value() . '.' . $extension;
    }

    public function saveFile(\Illuminate\Http\UploadedFile $file): void
    {
        $route = $this->path()->value() . $this->nameNow()->value();
        Storage::disk('local')->put($route, $file);
    }

    /**
     * Get the value of id
     */
    public function id(): Id
    {
        return $this->id;
    }

    /**
     * Get the value of documentId
     */
    public function documentId(): DocumentId
    {
        return $this->documentId;
    }

    /**
     * Set the value of documentId
     *
     * @return  self
     */
    public function updateDocumentId(string $documentId): self
    {
        $this->documentId = DocumentId::fromPrimitives($documentId);

        return $this;
    }
    /**
     * Get the value of typeArchive
     */
    public function typeArchive(): TypeArchive
    {
        return $this->typeArchive;
    }

    /**
     * Set the value of typeArchive
     *
     * @return  self
     */
    public function updateTypeArchive(string $typeArchive): self
    {
        $this->typeArchive = TypeArchive::fromString($typeArchive);

        return $this;
    }

    /**
     * Get the value of path
     */
    public function path(): Path
    {
        return $this->path;
    }

    /**
     * Set the value of path
     *
     * @return  self
     */
    public function updatePath(String $path): self
    {
        $this->path = Path::fromString($path);

        return $this;
    }

    /**
     * Get the value of nameNow
     */
    public function nameNow(): NameNow
    {
        return $this->nameNow;
    }

    /**
     * Set the value of nameNow
     *
     * @return  self
     */
    public function updateNameNow(String $nameNow): self
    {
        $this->nameNow = NameNow::fromString($nameNow);

        return $this;
    }

    /**
     * Get the value of namePrevious
     */
    public function namePrevious(): NamePrevious
    {
        return $this->namePrevious;
    }

    /**
     * Set the value of namePrevious
     *
     * @return  self
     */
    public function updateNamePrevious(String $namePrevious): self
    {
        $this->namePrevious = NamePrevious::fromString($namePrevious);

        return $this;
    }

    /**
     * Get the value of processId
     */
    public function processId(): ProcessId
    {
        return $this->processId;
    }

    /**
     * Set the value of processId
     *
     * @return  self
     */
    public function updateProcessId(string $processId): self
    {
        $this->processId = ProcessId::fromPrimitives($processId);

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function createdAt(): DateTimeValueObject
    {
        return $this->created_at;
    }

    /**
     * Get the value of updated_at
     */
    public function updatedAt(): ?DateTimeValueObject
    {
        return $this->updated_at;
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'document_id' => $this->documentId()->value(),
            'type_archive' => $this->typeArchive()->value(),
            'path' => $this->path()->value(),
            'name_now' => $this->nameNow()->value(),
            'name_previous' => $this->namePrevious()->value(),
            'process_id' => $this->processId()->value(),
            'created_at' => $this->createdAt()->value(),
            'updated_at' => $this->updatedAt()?->value(),
        ];
    }
}
