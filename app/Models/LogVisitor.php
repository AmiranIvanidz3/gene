<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogVisitor extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }

    public function reel()
    {
        return $this->belongsTo(Reel::class, 'reel_id');
    }
}
