<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcludedUserAgentRequests extends Model
{
    use HasFactory;

    protected $table = "excluded_ua_requests";

    public function userAgent ()
    {
        return $this->belongsTo(ExcludedUserAgents::class, 'user_agent_id');
    }
}
