<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Helpers\ConfigHelper;
use App\Exceptions\ConfigException;

class ConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws ConfigException
     */
    public function run()
    {
        // Password
        ConfigHelper::store('password', 'change', 'bool', 1, false, ['type' => 'unlimited']);
        ConfigHelper::store('password', 'interval', 'integer', 30, false, ['type' => 'unlimited']);
        ConfigHelper::store('password', 'repeat', 'bool', 0, false, ['type' => 'unlimited']);
        ConfigHelper::store('password', 'limit', 'integer', 5, false, ['type' => 'unlimited']);
        // Default

    }
}
