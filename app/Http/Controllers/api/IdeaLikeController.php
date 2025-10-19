<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaLikeController extends Controller
{
    /**
     * Like a given idea.
     */
    public function like(Request $request, Idea $idea)
    {
        /** @var \App\Models\User $liker */
        $liker = $request->user();

        // Prevent duplicate likes
        if ($liker->likes()->where('idea_id', $idea->id)->exists()) {
            return response()->json([
                'message' => 'You have already liked this idea.',
                'likes_count' => $idea->likes()->count()
            ], 409); // 409 Conflict status code
        }

        $liker->likes()->attach($idea);

        return response()->json([
            'message' => 'Idea liked successfully!',
            'likes_count' => $idea->likes()->count()
        ]);
    }

    /**
     * Unlike a given idea.
     */
    public function unlike(Request $request, Idea $idea)
    {
        /** @var \App\Models\User $liker */
        $liker = $request->user();

        $liker->likes()->detach($idea);

        return response()->json([
            'message' => 'Idea unliked successfully!',
            'likes_count' => $idea->likes()->count()
        ]);
    }
}
