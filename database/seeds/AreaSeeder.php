<?php

use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //['name' => '', 'description' => ''],
        $areas = [
            ['name' => 'Acabado 1', 'description' => 'Acabado 1'],
            ['name' => 'Acabado 2', 'description' => 'Acabado 2'],
            ['name' => 'Administración', 'description' => 'Administración'],
            ['name' => 'Almacen Materia Prima', 'description' => 'Almacen Materia Prima'],
            ['name' => 'Despacho', 'description' => 'Despacho'],
            ['name' => 'Gerencia', 'description' => 'Gerencia'],
            ['name' => 'Horno', 'description' => 'Horno'],
            ['name' => 'Lijado', 'description' => 'Lijado'],
            ['name' => 'Mantenimiento', 'description' => 'Mantenimiento'],
            ['name' => 'Maquinado I', 'description' => 'Maquinado I'],
            ['name' => 'Maquinado II', 'description' => 'Maquinado II'],
            ['name' => 'Maquinado III', 'description' => 'Maquinado III'],
            ['name' => 'Planta', 'description' => 'Planta'],
        ];
        foreach ($areas as $area) {
            App\Area::create($area);
        }
    }
}
