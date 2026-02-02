<?php

namespace Database\Seeders;

use App\Models\Administrativo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

//protected $fillable = ['nombre', 'apellidos', 'email', 'telefono', 'imagen'];
class AdministrativoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $faker = Faker::create('es_ES');

        for ($i = 0; $i < 10; $i++) {
            Administrativo::create([
                'nombre' => $faker->name(),
                'apellidos' => $faker->lastName(),
                'email' => $faker->email(),
                'telefono' => $faker->buildingNumber(),
                'imagen' => $faker->url(),
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
                'observaciones' => $faker->catchPhrase(),
                'contrasenya'=>$faker->password()
            ]);
        }
    }
}
