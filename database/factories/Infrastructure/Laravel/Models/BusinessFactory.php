<?php

namespace Database\Factories\Infrastructure\Laravel\Models;

use App\Domain\Shared\ValueObjects\Id;
use App\Infrastructure\Laravel\Models\Business;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class BusinessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model. * * @var string
     */
    protected $model = Business::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => Id::random()->value(),
            'business_name' => fake()->name(),
            'phone' => fake()->numberBetween(1, 30000),
            'nit' => fake()->numberBetween(1000, 99999),
            'address' => fake()->address(),
            'department' => fake()->name(),
            'city' => fake()->city(),
            'type_person' => 'natural',
            'city_register' => fake()->city(),
            'email' => fake()->safeEmail(),
            'expiration_date' => null,
        ];
    }
}
