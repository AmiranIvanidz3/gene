<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitState extends Model
{
    use HasFactory;

    protected $table = 'visit_state';
    const CREATED_AT = 'datetime_current';
    const UPDATED_AT = 'updated_at';
}
