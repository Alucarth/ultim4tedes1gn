<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->
            insert([
                ['name' => 'activo', 'description' => '', 'level' => 0],
                ['name' => 'terminado', 'description' => '', 'level' => 0]
            ]);
    }
}
