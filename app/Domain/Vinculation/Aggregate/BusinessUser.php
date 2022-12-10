<?php

declare(strict_types=1);

namespace App\Domain\Vinculation\Aggregate;

use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Vinculation\ValueObjects\BusinessId;
use App\Domain\Vinculation\ValueObjects\Id;
use App\Domain\Vinculation\ValueObjects\UserId;

final class BusinessUser
{
    private function __construct(
        private Id $id,
        private BusinessId $business_id,
        private UserId $user_id,
        private DateTimeValueObject $created_at,
        private ?DateTimeValueObject $updated_at
    ) {
    }

    public static function create(
        Id $id,
        BusinessId $business_id,
        UserId $user_id,
        DateTimeValueObject $created_at,
        ?DateTimeValueObject $updated_at = null
    ): self {
        return new self(
            $id,
            $business_id,
            $user_id,
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
     * Get the value of business_id
     */
    public function businessId(): BusinessId
    {
        return $this->business_id;
    }

    /**
     * Set the value of business_id
     *
     * @return  self
     */
    public function updateBusinessId($business_id): self
    {
        $this->business_id = $business_id;

        return $this;
    }
    /**
     * Get the value of user_id
     */
    public function userId(): UserId
    {
        return $this->user_id;
    }

    /**
     * Set the value of user_id
     *
     * @return  self
     */
    public function updateUserId($user_id): self
    {
        $this->user_id = $user_id;

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
            'user_id' => $this->businessId()->value(),
            'business_id' => $this->businessId()->value(),
            'created_at' => $this->createdAt()->value(),
            'updated_at' => $this->updatedAt()?->value(),
        ];
    }
}
