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

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 3; $i++) { 
            User::insert($this->data($i));
        }

        $business = Business::all();

        // Populate the pivot table
        User::all()->each(function ($user) use ($business) { 
            $user->business()->attach(
                $business->random(rand(1, 1))->pluck('id')->toArray(),
                [ 'id' => UlidValueObject::random()->__toString()]
            ); 
        });
    }

    public function data(int $count)
    {
        $document = DB::table('type_documents')->where('initials', 'C.C.')->get('id')->first();
        return [
            [
                'id' => UlidValueObject::random(),
                'name' => 'Jonathan',
                'last_name' => 'Garzon',
                'email' => "jonatangarzon+$count@gmail.com",
                'identification' => '1121940890',
                'type_document_id' => $document->id,
                'cell_phone' => '3213860504',
                'city' => 'Villavicencio',
                'address' => 'cll 30 17b',
                'city_register' => 'Villavicencio',
                'is_manager' => true,
                'is_signer' => true,
                'is_verified' => 'id_banlinea',
                'password' => Hash::make('Lol123Lol@'),
            ]
        ];
    }
}
