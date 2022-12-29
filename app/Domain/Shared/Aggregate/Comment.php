<?php

declare(strict_types=1);

namespace App\Domain\Shared\Aggregate;

use App\Domain\Shared\ValueObjects\Comment\Comment as CommentComment;
use App\Domain\Shared\ValueObjects\Comment\ProcessId;
use App\Domain\Shared\ValueObjects\Comment\State;
use App\Domain\Shared\ValueObjects\Comment\UserId;
use App\Domain\Shared\ValueObjects\DateTimeValueObject;
use App\Domain\Shared\ValueObjects\Id;

final class Comment
{
    private function __construct(
        private Id $id,
        private CommentComment $comment,
        private ProcessId $processId,
        private State $state,
        private UserId $userId,
        private DateTimeValueObject $created_at,
        private ?DateTimeValueObject $updated_at
    ) {
    }

    public static function create(
        Id $id,
        CommentComment $comment,
        ProcessId $processId,
        State $state,
        UserId $userId,
        DateTimeValueObject $created_at,
        ?DateTimeValueObject $updated_at = null
    ): self {
        return new self(
            $id,
            $comment,
            $processId,
            $state,
            $userId,
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
     * Get the value of comment
     */
    public function comment(): CommentComment
    {
        return $this->comment;
    }

    /**
     * Set the value of comment
     *
     * @return  self
     */
    public function updateComment(string $comment): self
    {
        $this->comment = CommentComment::fromString($comment);

        return $this;
    }

    /**
     * Get the value of processId
     */
    public function processId(): ProcessId
    {
        return $this->processId;
    }

    /**
     * Set the value of processId
     *
     * @return  self
     */
    public function updateProcessId(string $processId): self
    {
        $this->processId = ProcessId::fromPrimitives($processId);

        return $this;
    }


    /**
     * Get the value of state
     */
    public function state(): State
    {
        return $this->state;
    }

    /**
     * Set the value of state
     *
     * @return  self
     */
    public function updateState(string $state): self
    {
        $this->state = State::fromString($state);

        return $this;
    }

    /**
     * Get the value of userId
     */
    public function userId(): UserId
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @return  self
     */
    public function updateUserId(string $userId): self
    {
        $this->userId = UserId::fromPrimitives($userId);

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
            'comment' => $this->comment()->value(),
            'process_id' => $this->processId()->value(),
            'state' => $this->state()->value(),
            'user_id' => $this->userId()->value(),
            'created_at' => $this->createdAt()->value(),
            'updated_at' => $this->updatedAt()?->value(),
        ];
    }
}
