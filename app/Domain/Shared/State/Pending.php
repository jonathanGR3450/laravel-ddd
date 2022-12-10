<?php

declare(strict_types=1);

namespace App\Domain\Shared\State;

class Pending extends ProcessState
{
    public function approved(): bool
    {
        return false;
    }
}
