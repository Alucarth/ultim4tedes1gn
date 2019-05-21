<?php

use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     //   factory(App\Provider::class, 500)->create();
         
         DB::statement('TRUNCATE TABLE providers RESTART IDENTITY CASCADE');

         	DB::table('providers')->insert(['name' => 'Bitumbo Bolivian Wood SRL', 
         		// 'offer'=>'Madera',
         		'description'=>'Diferentes especies de madera',]); 
			DB::table('providers')->insert(['name' => 'Lorena Denice Camacho', 
				// 'offer'=>'Madera',
				'description'=>'Diferentes especies de madera',]); 
			DB::table('providers')->insert(['name' => 'Barraca Coco', 
				// 'offer'=>'Madera',
				'description'=>'Diferentes especies de madera',]); 
			DB::table('providers')->insert(['name' => 'Exceso en Recuento Fisico (M)', 
				// 'offer'=>'Madera',
				'description'=>'Ajuste por Diferencias en Recuento Fisico en almacenes',]); 
			DB::table('providers')->insert(['name' => 'Dekma Bolivia S.A.', 
				// 'offer'=>'Madera',
				'description'=>'Diferentes especies de madera',]); 
			DB::table('providers')->insert(['name' => 'Felzi Gamez', 
				// 'offer'=>'Madera',
				'description'=>'Diferentes especies de madera',]); 
			DB::table('providers')->insert(['name' => 'Ultimate Design SRL', 
				// 'offer'=>'Madera',
				'description'=>'Inventario Inicial, Pedidos Stock, etc.',]); 
			DB::table('providers')->insert(['name' => 'Ovidio Escalante', 
				// 'offer'=>'Madera',
				'description'=>'Diferentes especies de madera',]); 
			DB::table('providers')->insert(['name' => 'Bolivian Timberland SRL', 
				// 'offer'=>'Madera',
				'description'=>'Diferentes especies de madera',]);
			DB::table('providers')->insert(['name' => 'Antonio Camilo Da Silva Filho', 
				// 'offer'=>'Madera',
				'description'=>'Diferentes especies de madera',]);
			DB::table('providers')->insert(['name' => 'Romelio Hurtado Gutierrez', 
				// 'offer'=>'Madera',
				'description'=>'Diferentes especies de madera',]);
    }
}
