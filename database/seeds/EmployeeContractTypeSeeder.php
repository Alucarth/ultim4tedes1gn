<?php

use Illuminate\Database\Seeder;

class EmployeeContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contracts = [
            ['name' => 'De Planta', 'description' => ''],
            ['name' => 'Eventual', 'description' => ''],            
        ];

        foreach($contracts as $contract) {
            App\EmployeeContractType::create($contract);
        }
    }
}
