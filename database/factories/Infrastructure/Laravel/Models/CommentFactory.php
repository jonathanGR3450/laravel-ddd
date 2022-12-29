<?php

namespace Database\Factories\Infrastructure\Laravel\Models;

use App\Domain\Shared\State\Approved;
use App\Domain\Shared\ValueObjects\Id;
use App\Infrastructure\Laravel\Models\Comment;
use App\Infrastructure\Laravel\Models\TypeDocument;
use App\Infrastructure\Laravel\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model. * * @var string
     */
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->make();
        return [
            'id' => Id::random()->value(),
            'comment' => fake()->text(),
            'state' => Approved::class,
            'user_id' => $user->id,
        ];
    }
}
