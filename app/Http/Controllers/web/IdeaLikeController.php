<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;


class IdeaLikeController extends Controller
{
    /**
     * like an idea
     */
    public function like(Idea $idea)
    {
        $liker = auth()->user();
        $liker->likes()->attach($idea);

        return response()->json([
            'likes_count' => $idea->likes()->count()
        ]);
    }

    /**
     * unlike an idea
     */
    public function unlike(Idea $idea)
    {
        $liker = auth()->user();
        $liker->likes()->detach($idea);

        return response()->json([
            'likes_count' => $idea->likes()->count()
        ]);
    }

}
