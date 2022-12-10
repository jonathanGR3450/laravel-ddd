<?php

declare(strict_types=1);

namespace App\Domain\Shared\State;

class Reject extends ProcessState
{
    public function approved(): bool
    {
        return false;
    }
}
