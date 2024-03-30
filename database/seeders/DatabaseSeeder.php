<?php

namespace Database\Seeders;

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
        $this->call([
            PermissionSeeder::class,
            ConfigsTableSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            UserActionSeeder::class,
            ParameterSeeder::class
           
        ]);

    }
}
