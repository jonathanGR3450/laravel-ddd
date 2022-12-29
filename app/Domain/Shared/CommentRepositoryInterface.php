<?php

declare(strict_types=1);

namespace App\Domain\Shared;

use App\Domain\Shared\Aggregate\Comment;

interface CommentRepositoryInterface
{
    public function create(Comment $comment): void;
}