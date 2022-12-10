<?php

declare(strict_types=1);

namespace App\Domain\Shared\State;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class ProcessState extends State
{
    abstract public function approved(): bool;

    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Pending::class)
            ->allowTransition(Pending::class, Approved::class)
            ->allowTransition(Pending::class, Reject::class)
        ;
    }
}