<?php

use Illuminate\Database\Seeder;

class OrderTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('order_types')->
            insert([
                ['name' => 'Interna', 'description' => '',],
                ['name' => 'Externa', 'description' => ''],
                ['name' => 'Venta directa', 'description' => ''],
                ['name' => 'Otros', 'description' => '']

            ]);
    }
}
