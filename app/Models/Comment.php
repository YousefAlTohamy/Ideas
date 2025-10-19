<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'idea_id',
        'content',
    ];

    // Comment's user
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Comment's idea
    public function idea() {
        return $this->belongsTo(Idea::class);
    }
}
