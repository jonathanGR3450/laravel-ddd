<?php

namespace Database\Seeders;

use App\Domain\Shared\ValueObjects\UlidValueObject;
use App\Infrastructure\Laravel\Models\TypeDocument;
use App\Infrastructure\Laravel\Models\User;
use App\Infrastructure\Laravel\Models\Business;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 3; $i++) {
            Business::insert($this->data());
        }
    }

    public function data()
    {
        return [
            [
                'id' => UlidValueObject::random(),
                'business_name' => fake()->name(),
                'phone' => fake()->numberBetween(89998, 9999999),
                'nit' => fake()->numberBetween(100000, 999999),
                'address' => fake()->address(),
                'department' => fake()->name(),
                'city' => fake()->name(),
                'type_person' => 'juridica',
                'city_register' => fake()->city(),
                'email' => fake()->safeEmail(),
                'expiration_date' => fake()->date(),
            ]
        ];
    }
}
