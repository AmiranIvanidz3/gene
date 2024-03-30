<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    public function user_actions()
    {
        return $this->HasMany(UserActon::class, 'action_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function action()
    {
        return $this->belongsTo(UserAction::class, "action_id");
    }

    
}
