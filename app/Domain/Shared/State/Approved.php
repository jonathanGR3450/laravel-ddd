<?php

declare(strict_types=1);

namespace App\Domain\Shared\State;

class Approved extends ProcessState
{
    public function approved(): bool
    {
        return true;
    }
}
