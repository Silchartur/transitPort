<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GestorSeeder::class,
            BuqueSeeder::class,
            PatioSeeder::class,
            ZonaSeeder::class,
            GruaSeeder::class,
            ParkingSeeder::class,
            ContenedorSeeder::class,
            AdministrativoSeeder::class,
            OrdenSeeder::class,
            OperarioSeeder::class,
            PassportClientesSeeder::class,
        ]);
    }
}
