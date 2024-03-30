<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function seenComment(){

        return $this->belongsToMany(User::class,'seen_comments','comment_id', 'user_id')->withTimestamps();
        
    }

    public function myseenComment()
    {
        return $this->belongsToMany(Comment::class, 'seen_comments', 'comment_id', 'comment_id')
                ->wherePivot('user_id', auth()->user()->id)
                ->withTimestamps();
    }

}
