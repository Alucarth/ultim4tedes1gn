<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);

        DB::table('roles')->insert([
            'name' => 'Administrador',
            'description' => 'Usuario Administrador ',
        ]);
        
        DB::table('role_users')->insert([
            'user_id' => 1,
            'role_id' => 1,
        ]);
       
    }
}
