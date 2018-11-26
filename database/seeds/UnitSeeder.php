<?php

use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $units = [
            ['code' => 'pie', 'name' => 'pie', 'description' => ''],
            ['code' => 'barra', 'name' => 'barra', 'description' => ''],
            ['code' => 'bolsa', 'name' => 'bolsa', 'description' => ''],
            ['code' => 'caja', 'name' => 'caja', 'description' => ''],
            ['code' => 'construccion', 'name' => 'construccion', 'description' => ''],
            ['code' => 'hoja', 'name' => 'hoja', 'description' => ''],
            ['code' => 'juego', 'name' => 'juego', 'description' => ''],
            ['code' => 'Kilo', 'name' => 'kilo', 'description' => ''],
            ['code' => 'Lamina', 'name' => 'Lamina', 'description' => ''],
            ['code' => 'Litro', 'name' => 'Litro', 'description' => ''],
            ['code' => 'Lote', 'name' => 'Lote', 'description' => ''],
            ['code' => 'M2', 'name' => 'M2', 'description' => ''],
            ['code' => 'Metro', 'name' => 'Metro', 'description' => ''],
            ['code' => 'ML', 'name' => 'ML', 'description' => ''],
            ['code' => 'Paquete', 'name' => 'Paquete', 'description' => ''],
            ['code' => 'Par', 'name' => 'Par', 'description' => ''],
            ['code' => 'Rollo', 'name' => 'Rollo', 'description' => ''],
            ['code' => 'Unidad', 'name' => 'Unidad', 'description' => ''],            
        ];

        foreach($units as $unit) {
            App\Unit::create($unit);
        }
    }
}
