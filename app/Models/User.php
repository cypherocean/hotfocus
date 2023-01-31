<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {

    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime'];

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function followers() {
        return $this->hasMany(FriendList::class, 'friend_id', 'id')->where('user_id', Auth::user()->id);
    }

    public function following() {
        return $this->hasMany(FriendList::class, 'user_id', 'id')->where('friend_id', Auth::user()->id);
    }

    public function isFollowing(User $user) {
        return !!$this->following()->where('user_id', $user->id)->count();
    }

    public function isFollowedBy(User $user) {
        return !!$this->followers()->where('friend_id', $user->id)->count();
    }

    public function chat() {
        return $this->hasMany(User::class);
    }
}
