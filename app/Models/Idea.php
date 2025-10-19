<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory;

    protected $with = ['user:id,name,image'];
    protected $withCount = ['likes', 'comments'];

    protected $fillable = [
        'user_id',
        'content',
    ];

    // Idea's comments
    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    // Idea's user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Idea's likes
    public function likes()
    {
        return $this->belongsToMany(User::class, 'idea_like')->withTimestamps();
    }
}
