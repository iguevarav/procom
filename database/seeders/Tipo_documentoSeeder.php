<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class Tipo_documentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_documento')->insert([
            [
                'descripcion' => 'DNI',
                'estado' => 'ACTIVO',
            ],
            [
                'descripcion' => 'RUC',
                'estado' => 'ACTIVO',
            ],
            [
                'descripcion' => 'Pasaporte',
                'estado' => 'ACTIVO',
            ],
            [
                'descripcion' => 'Carnet de Extranjería',
                'estado' => 'ACTIVO',
            ],
        ]);
    }
}