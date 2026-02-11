<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Laravel\Passport\Client;

class PassportClientesSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            [
                'name' => 'Gestor',
                'provider' => 'gestores',
            ],
            [
                'name' => 'Administrativo',
                'provider' => 'administrativos',
            ],
            [
                'name' => 'Operario',
                'provider' => 'operarios',
            ],
        ];

        foreach ($clients as $client) {
            Client::updateOrCreate(
                [
                    'name' => $client['name'],
                ],
                [
                    'secret' => bcrypt(str()->random(40)),
                    'provider' => $client['provider'],
                    'redirect_uris' => [],
                    'grant_types' => ['personal_access'],
                    'revoked' => false,
                ]
            );
        }
    }
}
