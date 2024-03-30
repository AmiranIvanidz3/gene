<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcludedUserAgents extends Model
{
    use HasFactory;
    
    protected $table = "excluded_ua";
    protected $fillable = ['user_agent', 'comment'];


}
