<?php

namespace Database\Factories\Infrastructure\Laravel\Models;

use App\Domain\Shared\ValueObjects\Id;
use App\Infrastructure\Laravel\Models\TypeDocument;
use App\Infrastructure\Laravel\Models\User;
use App\Infrastructure\Laravel\Models\Business;
use App\Infrastructure\Laravel\Models\BusinessUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class BusinessUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model. * * @var string
     */
    protected $model = BusinessUser::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->make();
        $business = Business::factory()->make();
        return [
            'id' => Id::random()->value(),
            'user_id' => $user->id,
            'business_id' => $business->id,
        ];
    }
}
