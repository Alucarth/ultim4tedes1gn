<?php

use Illuminate\Database\Seeder;

class LumberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Lumber::class, 1000)->create();
    }
}
