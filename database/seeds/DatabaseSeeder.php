<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([UsersTableSeeder::class,
                	SpecieSeeder::class,
                	TypeSeeder::class,
                    ProviderSeeder::class,
                    SpecieSeeder::class,
                    UnitSeeder::class,
                    StateSeeder::class,
                    LumberSeeder::class,
                    OriginTypeSeeder::class,
                    InventoryTypeSeeder::class,
                    FamilySeeder::class,
                    StatusesTableSeeder::class,
                    OrderTypeTableSeeder::class,
                    ProductTypeTableSeeder::class,
                    ContractTypeSeeder::class,
                    ]);
    }
}
