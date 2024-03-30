<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModalNew extends Model
{
    use HasFactory, SoftDeletes;

    public function userSeen(){
        return $this->hasMany(UserSeenNews::class, 'news_id', 'id');
    }
}
