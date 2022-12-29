<?php

declare(strict_types=1);

namespace App\Application\Shared;

use App\Application\Auth\Contracts\AuthUserInterface;
use App\Domain\Shared\Aggregate\Comment;
use App\Domain\Shared\CommentRepositoryInterface;
use App\Domain\Shared\State\Approved;
use App\Domain\Shared\State\Reject;
use App\Domain\Shared\ValueObjects\Comment\Comment as CommentComment;
use App\Domain\Shared\ValueObjects\Comment\ProcessId;
use App\Domain\Shared\ValueObjects\Comment\State;
use App\Domain\Shared\ValueObjects\Comment\UserId;
use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Id;

final class CreateCommentUseCase
{
    private CommentRepositoryInterface $commentRepositoryInterface;
    private AuthUserInterface $authUserInterface;

    public function __construct(
            CommentRepositoryInterface $commentRepositoryInterface,
            AuthUserInterface $authUserInterface
        ) {
        $this->commentRepositoryInterface = $commentRepositoryInterface;
        $this->authUserInterface = $authUserInterface;
    }

    public function __invoke(
        string $observation,
        string $process_id,
        bool $state,
    ): Comment
    {
        $user = $this->authUserInterface->getAuthUserAgreggate();
        $comment = Comment::create(
            Id::random(),
            CommentComment::fromString($observation),
            ProcessId::fromPrimitives($process_id),
            State::fromString($state ? Approved::class : Reject::class),
            UserId::fromPrimitives($user->id()->value()),
            DateTimeValueObject::now()
        );

        $this->commentRepositoryInterface->create($comment);

        return $comment;
    }
}