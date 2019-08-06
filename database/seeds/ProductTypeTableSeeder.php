<?php

use Illuminate\Database\Seeder;

class ProductTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('product_types')->
            insert([
                ['name' => 'Contraplacada', 'description' => ''],
                ['name' => 'Ing. Mixta', 'description' => ''],
                ['name' => '2x4', 'description' => ''],
                ['name' => 'Otro', 'description' => ''],
            ]);
    }
}
