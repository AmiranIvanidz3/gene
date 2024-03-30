<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $table = "procedure";

    public function procedureType(){
        return $this->belongsTo(ProcedureType::class, 'procedure_type_id');
    }
}
