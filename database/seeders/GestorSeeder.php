<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class GestorSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES');

        for ($i = 0; $i < 20; $i++) {
            DB::table('gestores')->insert([
                'name' => $faker->firstName(),
                'apellidos' => $faker->lastName() . ' ' . $faker->lastName(),
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => bcrypt('123456'),
                'telefono' => $faker->numberBetween(600000000, 799999999),
                'imagen' => 'https://i.pravatar.cc/300?u=' . $faker->unique()->safeEmail,
                'observaciones' => $faker->text(200),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
