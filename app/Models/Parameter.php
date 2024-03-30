<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use HasFactory, SoftDeletes;


    public static $parameters = [];

    public static function getValue($key)
    {
        if(empty(self::$parameters)){
            $array = self::get()->toArray();
            // $record = $array[$key];
            
            foreach($array as $item){
                self::$parameters[$item['key']] = $item['value'];
            }
        }
        $record = self::$parameters[$key];

        return $record ?? null;
    }
}