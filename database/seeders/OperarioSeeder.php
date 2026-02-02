<?php

namespace Database\Seeders;

use App\Models\Operario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

/**
 *  protected $fillable = ['tipo','nombre', 'apellidos', 'email', 'telefono','imagen'];
 */
class OperarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $faker = Faker::create('es_ES');

        for ($i = 0; $i < 10; $i++) {
            Operario::create([
                'tipo' => $faker->jobTitle(),
                'nombre' => $faker->firstName(),
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
