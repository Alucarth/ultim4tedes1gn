<?php

use Illuminate\Database\Seeder;

class ReceiptTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('receipt_types')->
            insert([
                ['name' => 'Factura', 'description' => ''],
                ['name' => 'Recibo', 'description' => ''],
                ['name' => 'Nota de venta', 'description' => ''],
                ['name' => 'Otro', 'description' => ''],
            ]);
    }
}
