<?php

use Illuminate\Database\Seeder;

class SpecieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('TRUNCATE TABLE species RESTART IDENTITY CASCADE');
    	//DB::table('species')->truncate();


        DB::table('species')->insert(['name' => 'Bibosi',]);
        DB::table('species')->insert(['name' => 'Bitumbo',]);
        DB::table('species')->insert(['name' => 'Cambara',]);
        DB::table('species')->insert(['name' => 'Cedro',]);
        DB::table('species')->insert(['name' => 'Cumaru',]);
        DB::table('species')->insert(['name' => 'Garapa',]);
        DB::table('species')->insert(['name' => 'Ipe Champagne',]);
        DB::table('species')->insert(['name' => 'Mani',]);
        DB::table('species')->insert(['name' => 'Mara Africano',]);
        DB::table('species')->insert(['name' => 'Mara Macho',]);
        DB::table('species')->insert(['name' => 'Marfil',]);
        DB::table('species')->insert(['name' => 'Morado',]);
        DB::table('species')->insert(['name' => 'Murure',]);
        DB::table('species')->insert(['name' => 'Ochoo',]);
        DB::table('species')->insert(['name' => 'Paquio',]);
		DB::table('species')->insert(['name' => 'Roble',]);
		DB::table('species')->insert(['name' => 'Tajibo',]);
		DB::table('species')->insert(['name' => 'Tajibo Colorado',]);
		DB::table('species')->insert(['name' => 'Tamarindo',]);
		DB::table('species')->insert(['name' => 'Varias Especies',]);
		DB::table('species')->insert(['name' => 'Yesquero Blanco',]);
		DB::table('species')->insert(['name' => 'Yesquero Negro',]);
    }
}
