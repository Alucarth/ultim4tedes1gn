<?php

use Illuminate\Database\Seeder;

class EmployeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            ['name' => 'Administrativo', 'description' => ''],
            ['name' => 'Encargado', 'description' => ''],
            ['name' => 'Operario', 'description' => ''],
        ];

        foreach($types as $type) {
            App\EmployeeType::create($type);
        }
    }
}
