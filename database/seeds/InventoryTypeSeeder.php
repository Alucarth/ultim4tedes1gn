<?php

use Illuminate\Database\Seeder;

class InventoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['name' => 'Herramientas y Repuestos', 'description' => ''],
            ['name' => 'Material de Acabado', 'description' => ''],
            ['name' => 'Material de Empaque', 'description' => ''],
            ['name' => 'Material de Lijado', 'description' => ''],
            ['name' => 'Material de Limpieza', 'description' => ''],
            ['name' => 'Material de Maquinado', 'description' => ''],
            ['name' => 'Material de Trabajo', 'description' => ''],
            ['name' => 'Material Directo', 'description' => ''],
            ['name' => 'Material Maquinado III', 'description' => ''],
            ['name' => 'Material para Obra', 'description' => ''],
            ['name' => 'Material Semiacabado', 'description' => ''],
            ['name' => 'Producto Terminado', 'description' => '']
        ];

        foreach($types as $type) {
            App\InventoryType::create($type);
        }
    }
}
