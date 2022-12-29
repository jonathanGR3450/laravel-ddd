<?php

namespace Database\Factories\Infrastructure\Laravel\Models;

use App\Domain\Shared\State\Pending;
use App\Domain\Shared\ValueObjects\Id;
use App\Infrastructure\Laravel\Models\TypeProcess;
use App\Infrastructure\Laravel\Models\User;
use App\Infrastructure\Laravel\Models\Business;
use App\Infrastructure\Laravel\Models\Process;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Infrastructure\Laravel\Models\Process>
 */
class ProcessFactory extends Factory
{
    /**
     * The name of the factory's corresponding model. * * @var string
     */
    protected $model = Process::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $typeProcess = TypeProcess::where('name', 'vinculacion')->get()->first();
        $user = User::factory()->create();
        $business = Business::factory()->create();

        return [
            'id' => Id::random()->value(),
            'type_process_id' => $typeProcess->id,
            'state' => Pending::class,
            'user_id' => $user->id,
            'business_id' => $business->id,
        ];
    }
}
