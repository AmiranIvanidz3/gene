<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureType extends Model
{
    use HasFactory;

    protected $table = "procedure_type";


    public function procedureGroup(){
        return $this->belongsTo(ProcedureGroup::class, 'procedure_group_id');
    }
}
