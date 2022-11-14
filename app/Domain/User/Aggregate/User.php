<?php

declare(strict_types=1);

namespace App\Domain\User\Aggregate;

use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\StringValueObject;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\Id;

final class User
{

    private function __construct(
        private Id $id,
        private Email $email,
        private StringValueObject $name,
        private DateTimeValueObject $created_at,
        private ?DateTimeValueObject $updated_at
    ) {
    }

    public static function create(
        Id $id,
        Email $email,
        StringValueObject $name,
        DateTimeValueObject $created_at,
        ?DateTimeValueObject $updated_at = null
    ): self
    {
        return new self(
            $id,
            $email,
            $name,
            $created_at,
            $updated_at
        );
    }

    public function id(): Id
    {
        return $this->id;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function name(): StringValueObject
    {
        return $this->name;
    }

    public function createdAt(): DateTimeValueObject
    {
        return $this->created_at;
    }

    public function updatedAt(): ?DateTimeValueObject
    {
        return $this->updated_at;
    }

    public function updateName(string $name): void
    {
        $this->name = StringValueObject::fromString($name);
    }

    public function updateEmail(string $email): void
    {
        $this->email = Email::fromString($email);
    }

    public function asArray(): array
    {
        return [
            'id' => $this->id()->value(),
            'email' => $this->email()->value(),
            'name' => $this->name()->value(),
            'created_at' => $this->createdAt()->value(),
            'updated_at' => $this->updatedAt()->value()
        ];
    }
}
