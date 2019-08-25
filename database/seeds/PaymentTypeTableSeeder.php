<?php

use Illuminate\Database\Seeder;

class PaymentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_types')->
            insert([
                ['name' => 'Efectivo', 'description' => ''],
                ['name' => 'Cheque', 'description' => ''],
                ['name' => 'Transferencia Bancaria', 'description' => ''],
                ['name' => 'Otro', 'description' => '']
            ]);
    }
}
