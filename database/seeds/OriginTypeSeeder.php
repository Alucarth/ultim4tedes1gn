<?php

use Illuminate\Database\Seeder;

class OriginTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('origin_types')
            ->insert([
                'name' => '#1025 compra interna', 
                'description'=>' compra interna a pepito perez de los palotes'
            ]);
        factory(App\OriginType::class, 50)->make();
    }
}
