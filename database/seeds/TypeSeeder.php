<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        DB::statement('TRUNCATE TABLE types RESTART IDENTITY CASCADE');

        DB::table('types')->insert(['name' => 'Aserrada A', 'description'=>'Madera de buena calidad.',]);
		DB::table('types')->insert(['name' => 'Aserrada B', 'description'=>'Madera de mediana calidad.',]);
		DB::table('types')->insert(['name' => 'Aserrada C', 'description'=>'Madera de baja calidad (relleno).',]);
		DB::table('types')->insert(['name' => 'Elaborada', 'description'=>'Madera elaborada de acuerdo a medidas.',]);
		DB::table('types')->insert(['name' => 'Finger', 'description'=>'Madera recuperada fingada para puertas.',]);
		DB::table('types')->insert(['name' => 'Finger Contramarco', 'description'=>'Madera recuperada fingada para contramarco',]);
		DB::table('types')->insert(['name' => 'Jamba', 'description'=>'Madera preelaborada jambas',]);
		DB::table('types')->insert(['name' => 'Marco Recuperacion', 'description'=>'Madera recuperada para Marcos.',]);
		DB::table('types')->insert(['name' => 'Precepillada', 'description'=>'Madera precepillada para marcos y puertas.',]);
		DB::table('types')->insert(['name' => 'Reciclada', 'description'=>'Madera que no sale de inventario.',]);
		DB::table('types')->insert(['name' => 'Zocalo', 'description'=>'Madera preelaborada zocalo',]);

    }
}
