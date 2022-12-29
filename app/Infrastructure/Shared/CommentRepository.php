<?php

declare(strict_types=1);

namespace App\Infrastructure\Shared;

use App\Domain\Shared\Aggregate\Comment;
use App\Domain\Shared\CommentRepositoryInterface;
use App\Domain\Shared\ValueObjects\Comment\Comment as CommentComment;
use App\Domain\Shared\ValueObjects\Comment\ProcessId;
use App\Domain\Shared\ValueObjects\Comment\State;
use App\Domain\Shared\ValueObjects\Comment\UserId;
use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Id;
use App\Infrastructure\Laravel\Models\Comment as ModelsComment;

class CommentRepository implements CommentRepositoryInterface
{

    public function create(Comment $comment): void
    {
        $commentModel = new ModelsComment();

        $commentModel->id = $comment->id()->value();
        $commentModel->comment = $comment->comment()->value();
        $commentModel->process_id = $comment->processId()->value();
        $commentModel->state = $comment->state()->value();
        $commentModel->user_id = $comment->userId()->value();

        $commentModel->save();
    }

    public static function map(ModelsComment $model): Comment
    {
        return Comment::create(
            Id::fromPrimitives($model->id),
            CommentComment::fromString($model->comment),
            ProcessId::fromPrimitives($model->process_id),
            State::fromString($model->state),
            UserId::fromPrimitives($model->user_id),
            DateTimeValueObject::fromPrimitives($model->created_at->__toString()),
            !empty($model->updated_at) ? DateTimeValueObject::fromPrimitives($model->updated_at->__toString()) : null,
        );
    }
}