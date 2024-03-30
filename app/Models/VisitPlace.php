<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitPlace extends Model
{
    use HasFactory;
    
    protected $table = 'visit_places';
    const CREATED_AT = 'datetime_current';
    const UPDATED_AT = 'updated_at';
}
