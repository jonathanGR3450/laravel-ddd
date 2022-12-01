<?php

namespace Database\Seeders;

use App\Domain\Shared\ValueObjects\UlidValueObject;
use App\Infrastructure\Laravel\Models\TypeDocument;
use App\Infrastructure\Laravel\Models\User;
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
        User::insert($this->data());
    }

    public function data()
    {
        $document = DB::table('type_documents')->where('initials', 'C.C.')->get('id')->first();
        return [
            [
                'id' => UlidValueObject::random(),
                'name' => 'Jonathan',
                'last_name' => 'Garzon',
                'email' => 'jonatangarzon95@gmail.com',
                'identification' => '1121940890',
                'type_document_id' => $document->id,
                'cell_phone' => '3213860504',
                'city' => 'Villavicencio',
                'address' => 'cll 30 17b',
                'expedition_city' => 'Villavicencio',
                'is_manager' => true,
                'is_signer' => true,
                'is_verified' => 'id_banlinea',
                'password' => Hash::make('Lol123Lol@'),
            ]
        ];
    }
}
