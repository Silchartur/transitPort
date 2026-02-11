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
                'name' => 'Aplicador',
                'provider' => 'aplicadores',
            ],
            [
                'name' => 'Administrador',
                'provider' => 'admins',
            ],
            [
                'name' => 'JefeCampo',
                'provider' => 'jefes',
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
