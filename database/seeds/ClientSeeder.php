<?php

use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->
            insert([
                [
                'name' => 'Cliente Prueba', 
                'legal_representative' => 'Cliente Prueba',
                'nit' => '12345678',
                'description' => 'Prueba de Descripcion',
                'phone' => '76543210',
                'address' => 'Calle Falsa No.123',
                ],
                [
                    'name' => 'Prueba S.R.L.', 
                    'legal_representative' => 'Pepito Perez',
                    'nit' => '87654321',
                    'description' => 'Prueba de Descripcion',
                    'phone' => '2356897',
                    'address' => 'Av. Falsa No.321',
                    ]
            ]);
    }
}
