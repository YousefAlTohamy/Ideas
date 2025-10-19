<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'user_name',
        'password',
        'image',
        'bio',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // User's ideas
    public function ideas()
    {
        return $this->hasMany(Idea::class)->latest();
    }

    // User's comments
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // User's followings
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follower_user', 'follower_id', 'user_id')->withTimestamps();
    }

    // User's followers
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follower_user', 'user_id', 'follower_id')->withTimestamps();
    }

    // Check if user follows someone
    public function follows(User $user)
    {
        return $this->followings()->where('user_id', $user->id)->exists();
    }

    // User's likes
    public function likes()
    {
        return $this->belongsToMany(Idea::class, 'idea_like')->withTimestamps();
    }

    // Check if user likes idea
    public function likesIdea(Idea $idea)
    {
        return $this->likes()->where('idea_id', $idea->id)->exists();
    }

    // Back user profile page
    public function getImageURL()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        return asset('imgs/default.png');
    }
}
