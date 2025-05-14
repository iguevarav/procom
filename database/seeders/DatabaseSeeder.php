<?php

namespace Database\Seeders;

use App\Models\Cargo;
use App\Models\Tipo_Proveedor;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            Tipo_documentoSeeder::class,
            Tipo_ProveedorSeeder::class,
            CargosSeeder::class,
        ]);
    }
}
