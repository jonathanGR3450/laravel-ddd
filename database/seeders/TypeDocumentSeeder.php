<?php

namespace Database\Seeders;

use App\Domain\Shared\ValueObjects\UlidValueObject;
use App\Infrastructure\Laravel\Models\TypeDocument;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TypeDocument::insert($this->data());
    }

    public function data()
    {
        return [
            [
                'id' => UlidValueObject::random(),
                'name' => 'Cédula de Extranjería',
                'initials' => 'C.E.',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'Cédula de Ciudadanía',
                'initials' => 'C.C.',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'Número Identificación Tributario',
                'initials' => 'NIT',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'Tarjeta de Identidad',
                'initials' => 'T.I.',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'Pasaporte',
                'initials' => 'P.',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'Documento de Identificación Extranjero para Persona Natural',
                'initials' => 'C.E.N.',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'Documento de Identificación Extranjero para Persona Jurídica',
                'initials' => 'C.E.J.',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'Carné Diplomático',
                'initials' => 'C.P.',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'Permiso por Protección Temporal',
                'initials' => 'P.P.T.',
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'Permiso Especial de Permanencia',
                'initials' => 'P.E.P.',
            ],
        ];
    }
}
