<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "product";



    public function productType(){
        return $this->belongsTo(ProductType::class, 'product_type_id', 'id');
    }

    public function unitType()
    {
        return $this->belongsTo(UnitType::class, 'unit_type_id', 'id');
    }
}
