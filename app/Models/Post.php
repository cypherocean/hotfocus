<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model {
    use HasFactory;


    public function likes() {
        return $this->hasMany(Like::class, 'post_id', 'id')->leftjoin('users', 'likes.user_id', 'users.id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id', 'id')->leftjoin('users', 'comments.user_id', 'users.id');
    }
}
