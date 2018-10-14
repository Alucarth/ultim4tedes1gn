<?php

use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $positions = [
            ['name' => 'Auxiliar de Contabilidad', 'description' => 'descripcion del elemento'], 
            ['name' => 'Ayudante', 'description' => 'descripcion del elemento'],
            ['name' => 'Clasificador de Madera', 'description' => 'descripcion del elemento'],
            ['name' => 'Encargado Acabado 1', 'description' => 'descripcion del elemento'],
            ['name' => 'Encargado Acabado 2', 'description' => 'descripcion del elemento'],
            ['name' => 'Encargado Almacen y Compras', 'description' => 'descripcion del elemento'],
            ['name' => 'Encargado Control De Produccion', 'description' => 'descripcion del elemento'],
            ['name' => 'Encargado de Despacho', 'description' => 'descripcion del elemento'],
            ['name' => 'Encargado Lijado', 'description' => 'descripcion del elemento'],
            ['name' => 'Encargado Maquinado  I', 'description' => 'descripcion del elemento'],
            ['name' => 'Encargado Maquinado II', 'description' => 'descripcion del elemento'],
            ['name' => 'Encargado Maquinado III', 'description' => 'descripcion del elemento'],
            ['name' => 'Encargado Sistemas', 'description' => 'descripcion del elemento'],
            ['name' => 'Gerente General', 'description' => 'descripcion del elemento'],
            ['name' => 'Jefe  de Planta', 'description' => 'descripcion del elemento'],
            ['name' => 'Jefe Encargado de  Mantenimiento', 'description' => 'descripcion del elemento'],
            ['name' => 'Montacarguista', 'description' => 'descripcion del elemento'],
            ['name' => 'Operador de Maquina', 'description' => 'descripcion del elemento'],
            ['name' => 'Secretaria - Enc. Logistica', 'description' => 'descripcion del elemento']
        ];

        foreach($positions as $position) {
            App\Position::create($position);
        }

    }
}
