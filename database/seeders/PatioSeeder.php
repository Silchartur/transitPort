<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patio;

class PatioSeeder extends Seeder
{
    public function run(): void
    {
        Patio::create([
            'capacidad' => 84,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
