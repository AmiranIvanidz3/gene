<?php

namespace Database\Seeders;

use App\Models\Parameter;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'key' => 'admin_dir',
                'value' => 'justadmin'
            ],
            [
                'key' => 'admin_title',
                'value' => 'admin_title'
            ],
            [
                'key' => 'referrer_letters_count',
                'value' => 25
            ],
            [
                'key' => 'create_new',
                'value' => "inshallah"
            ],
            [
                'key' => 'modal_news_seconds',
                'value' => "5"
            ],
            [
                'key' => 'per_page',
                'value' => 10
            ],
            [
                'key' => 'search_color',
                'value' => 'red'
            ],
            [
                'key' => 'title',
                'value' => 'title_from_db'
            ],
            [
                'key' => 'reel_show_more_letters_count',
                'value' => '10'
            ],
            [
                'key' => 'modal_news_seconds',
                'value' => '10'
            ],
            [
                'key' => 'logo_title',
                'value' => 'hello'
            ]
        ];

        foreach($data as $singleData){
            Parameter::create($singleData);
        }
    }
}
