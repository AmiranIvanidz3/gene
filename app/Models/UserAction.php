<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAction extends Model
{
    use HasFactory;

    public function log()
    {
        return $this->belongsTo(Log::class, 'action_id');
    }

}
