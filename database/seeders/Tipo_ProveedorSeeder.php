<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Tipo_ProveedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipos_proveedor')->insert([
            [
                'descripcion' => 'EXTRANJERO',
                'estado' => 'ACTIVO',
            ],
            [
                'descripcion' => 'NACIONAL',
                'estado' => 'ACTIVO',
            ],
            [
                'descripcion' => 'LOCAL',
                'estado' => 'ACTIVO',
            ],
        ]);
    }
}
