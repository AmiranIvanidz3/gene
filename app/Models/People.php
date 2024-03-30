<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    public function father(){
        return $this->belongsTo(People::class, 'father_id', 'id');
    }

    public function mother(){
        return $this->belongsTo(People::class, 'mother_id', 'id');
    }
}
