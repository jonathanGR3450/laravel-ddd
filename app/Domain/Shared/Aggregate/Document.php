<?php

declare(strict_types=1);

namespace App\Domain\Shared\Aggregate;

use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Description;
use App\Domain\Shared\ValueObjects\Document\TypeProcessId;
use App\Domain\Shared\ValueObjects\Id;
use App\Domain\Shared\ValueObjects\Name;

final class Document
{
    private function __construct(
        private Id $id,
        private Name $name,
        private Description $description,
        private TypeProcessId $typeProcessId,
        private DateTimeValueObject $created_at,
        private ?DateTimeValueObject $updated_at
    ) {
    }

    public static function create(
        Id $id,
        Name $name,
        Description $description,
        TypeProcessId $typeProcessId,
        DateTimeValueObject $created_at,
        ?DateTimeValueObject $updated_at = null
    ): self {
        return new self(
            $id,
            $name,
            $description,
            $typeProcessId,
            $created_at,
            $updated_at
        );
    }

    /**
     * Get the value of id
     */
    public function id(): Id
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */
    public function name(): Name
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function updateName($name): self
    {
        $this->name = $name;

        return $this;
    }
    /**
     * Get the value of description
     */
    public function description(): Description
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function updateDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function typeProcessId(): TypeProcessId
    {
        return $this->typeProcessId;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function updatetypeProcessId(String $typeProcessId): self
    {
        $this->typeProcessId = TypeProcessId::fromPrimitives($typeProcessId);

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
            'name' => $this->name()->value(),
            'description' => $this->description()->value(),
            'type_process_id' => $this->typeProcessId()->value(),
            'created_at' => $this->createdAt()->value(),
            'updated_at' => $this->updatedAt()?->value(),
        ];
    }
}
