<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\Shared\Model\Criteria;
use App\Domain\Shared\Model\CriteriaPagination;

final class UserSearchCriteria extends Criteria
{
    public const PAGINATION_SIZE = 10;

    private ?string $email = null;
    private ?string $name = null;

    public static function create(?int $offset = null, ?string $name = null, ?string $email = null): UserSearchCriteria
    {
        $criteria = new self(
            CriteriaPagination::create(self::PAGINATION_SIZE, $offset)
        );

        $email ?? $criteria->email = $email;
        $name ?? $criteria->name = $name;

        return $criteria;
    }

    public function name(): ?string
    {
        return $this->name;
    }

    public function email(): ?string
    {
        return $this->email;
    }
}