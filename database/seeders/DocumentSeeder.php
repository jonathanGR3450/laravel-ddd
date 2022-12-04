<?php

namespace Database\Seeders;

use App\Domain\Shared\ValueObjects\UlidValueObject;
use App\Infrastructure\Laravel\Models\Document;
use App\Infrastructure\Laravel\Models\TypeProcess;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Document::insert($this->data());
    }

    public function data()
    {
        $vinculacion = TypeProcess::where('name', 'vinculacion')->get('id')->first();
        $reclasificacion = TypeProcess::where('name', 'reclasificacion')->get('id')->first();
        $desembolso = TypeProcess::where('name', 'desembolso')->get('id')->first();
        $recaudo = TypeProcess::where('name', 'recaudo')->get('id')->first();
        $solicitud = TypeProcess::where('name', 'solicitud')->get('id')->first();
        return [
            [
                'id' => UlidValueObject::random(),
                'name' => 'vinculacion',
                'description' => 'Vinculación',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'contratomarco',
                'description' => 'Contrato Marco',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'estadosfinancieros_2',
                'description' => 'Estados Financieros 2',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'estadosfinancieros_3',
                'description' => 'Estados Financieros 3',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'estadosfinancieros_4',
                'description' => 'Estados Financieros 4',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'camaracomercio',
                'description' => 'Camara Comercio',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'rut',
                'description' => 'Registro unico tributario',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'composicionaccionaria',
                'description' => 'Composción Accionaria',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'declaracionrenta',
                'description' => 'Declaracion de Renta',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'estadosfinancieros',
                'description' => 'Estados Financieros',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'certificacionbancaria',
                'description' => 'Certificación Bancaria',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'certificadocesion',
                'description' => 'Certificado Cesion',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'certificadocontratomarco',
                'description' => 'certificado Contrato Marco',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'cedula',
                'description' => 'Cedula',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'composicionaccionaria_file',
                'description' => 'Composicion Accionaria File',
                'type_process_id' => $vinculacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'contratoderechos',
                'description' => 'Contrato Derechos',
                'type_process_id' => $solicitud->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'facturas',
                'description' => 'Facturas',
                'type_process_id' => $solicitud->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'firma',
                'description' => 'Firma',
                'type_process_id' => $solicitud->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'reclasificacion',
                'description' => 'Feclasificacion',
                'type_process_id' => $reclasificacion->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'contratoventa',
                'description' => 'Contrato Venta',
                'type_process_id' => $desembolso->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'certificadodesembolso',
                'description' => 'Certificado Desembolso',
                'type_process_id' => $desembolso->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'liquidacion',
                'description' => 'Liquidacion',
                'type_process_id' => $desembolso->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'autorizacion_acreedor',
                'description' => 'Autorizacion Acreedor',
                'type_process_id' => $desembolso->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'solicitud_desembolso_acreedor',
                'description' => 'solicitud Desembolso Acreedor',
                'type_process_id' => $desembolso->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'recepcion_recursos_fiduciaria',
                'description' => 'Recepcion Recursos Fiduciaria',
                'type_process_id' => $desembolso->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'pago_fiduciaria',
                'description' => 'Pago Fiduciaria',
                'type_process_id' => $desembolso->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'certificadopago',
                'description' => 'Certificado Pago',
                'type_process_id' => $recaudo->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'certificadorecaudo',
                'description' => 'Certificado Recaudo',
                'type_process_id' => $recaudo->id,
            ],
            [
                'id' => UlidValueObject::random(),
                'name' => 'certificado1pago',
                'description' => 'Certificado 1 Pago',
                'type_process_id' => $recaudo->id,
            ],
        ];
    }
}
