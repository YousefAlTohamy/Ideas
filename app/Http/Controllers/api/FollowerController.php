<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    /**
     * Follow a user.
     */
    public function follow(Request $request, User $user)
    {
        /** @var \App\Models\User $follower */
        $follower = $request->user();

        // Prevent a user from following themselves
        if ($follower->id === $user->id) {
            return response()->json(['message' => 'You cannot follow yourself.'], 422);
        }

        // Use syncWithoutDetaching to prevent creating duplicate follow records
        $follower->followings()->syncWithoutDetaching($user->id);

        return response()->json([
            'message' => 'User followed successfully!',
            'followers_count' => $user->followers()->count(),
            'followings_count' => $follower->followings()->count()
        ]);
    }


    /**
     * Unfollow a user.
     */
    public function unfollow(Request $request, User $user)
    {
        /** @var \App\Models\User $follower */
        $follower = $request->user();

        // The detach method returns the number of detached records.
        $detached = $follower->followings()->detach($user->id);

        // If detach returns 0, it means the user wasn't being followed in the first place.
        if ($detached === 0) {
            return response()->json([
                'message' => 'You were not following this user.',
                'followers_count' => $user->followers()->count(),
                'followings_count' => $follower->followings()->count()
            ]);
        }

        return response()->json([
            'message' => 'User unfollowed successfully!',
            'followers_count' => $user->followers()->count(),
            'followings_count' => $follower->followings()->count(),
        ]);
    }
}
