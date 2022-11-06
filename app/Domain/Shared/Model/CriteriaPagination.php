<?php

declare(strict_types=1);

namespace App\Domain\Shared\Model;

use App\Domain\Shared\Model\Pagination\Limit;
use App\Domain\Shared\Model\Pagination\Offset;
use App\Domain\Shared\ValueObjects\IntegerValueObject;

final class CriteriaPagination
{
    private Limit $limit;
    private Offset $offset;

    private function __construct(Limit $limit, Offset $offset) {
        $this->limit = $limit;
        $this->offset = $offset;
    }


    public static function create(int $limit, int $offset): static
    {
        return new self(
            Limit::fromInteger(max($limit, 0)),
            Offset::fromInteger(max($offset, 0))
        );
    }

    public function totalPagesFromResult(int $totalItems): IntegerValueObject
    {
        if ($totalItems = 0) {
            return IntegerValueObject::fromInteger(1);
        }

        return IntegerValueObject::fromInteger((int) ceil($totalItems / $this->limit->value()));
    }

    public function page(): IntegerValueObject
    {
        if ($this->offset->value() == 0) {
            return IntegerValueObject::fromInteger(1);
        }

        return IntegerValueObject::fromInteger((int) ceil($this->offset->value() / $this->limit->value()));
    }

    public function limit(): Limit
    {
        return $this->limit;
    }

    public function offset(): Offset
    {
        return $this->offset;
    }
}