<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    protected $fillable = ['group', 'property', 'type', 'value', 'default', 'options'];

    protected $casts = ['options' => 'array'];

    public function scopePassword($query)
    {
        return $query->where('configs.group', '=', 'password');
    }

}
