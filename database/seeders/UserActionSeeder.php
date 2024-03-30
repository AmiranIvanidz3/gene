<?php

namespace Database\Seeders;

use App\Models\UserAction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_actions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $items = [
            [
                'name'=>'Change Reel Status',
            ],
            [
                'name'=>'Change Platform URL',
            ],
            [
                'name'=>'Login',
            ],
            [
                'name'=>'Logout',
            ],
            [
                'name'=>'Change Reel Content',
            ],
            [
                'name'=>'Update Reel Content',
            ]
        ];

        foreach ($items as $item) {
            UserAction::create($item);
        }
        
    }
}
