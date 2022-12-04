<?php

namespace Database\Seeders;

use App\Domain\Shared\ValueObjects\UlidValueObject;
use App\Infrastructure\Laravel\Models\TypeProcess;
use Illuminate\Database\Seeder;

class TypeProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeProcess::insert($this->data());
    }

    public function data()
    {
        return [
            [
                'id' => UlidValueObject::random(),
                'name' => 'vinculacion',
                'description' => 'Vinculación',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'reclasificacion',
                'description' => 'Reclasificación',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'desembolso',
                'description' => 'Desembolso',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'recaudo',
                'description' => 'Recaudo',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'solicitud',
                'description' => 'Cesión de Derechos de Crédito',
            ]
        ];
    }
}
