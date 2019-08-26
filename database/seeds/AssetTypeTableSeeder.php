<?php

use Illuminate\Database\Seeder;

class AssetTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('asset_types')->
            insert([
                ['name' => 'Muebles y Enseres', 'description' => ''],
                ['name' => 'Equipos de Computacion', 'description' => ''],
                ['name' => 'Vehiculos', 'description' => ''],
                ['name' => 'Maquinaria y Equipo', 'description' => ''],
                ['name' => 'Herramientas', 'description' => ''],
                ['name' => 'Terreno', 'description' => ''],
                ['name' => 'Edificaciones', 'description' => ''],
            ]);
    }
}
