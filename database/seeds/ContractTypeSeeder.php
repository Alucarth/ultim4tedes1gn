<?php

use Illuminate\Database\Seeder;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contract_types')->
            insert([
                ['name' => 'Tipo1', 'description' => ''],
                ['name' => 'Tipo2', 'description' => '']
            ]);
    }
}
