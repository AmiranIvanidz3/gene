<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IpRequest extends Model
{
    use HasFactory;


    protected $table = "excluded_ip_requests";

    public function ip()
    {
        return $this->belongsTo(ExcludedIp::class, 'ip_id');
    }

}
