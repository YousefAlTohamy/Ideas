<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;


class FollowerController extends Controller
{

    /**
     * Follow a user.
     */
    public function follow(User $user)
    {
        $follower = auth()->user();
        $follower->followings()->attach($user);

        return response()->json([
            'following' => true,
            'followers_count' => $user->followers()->count(),
            'followings_count' => $follower->followings()->count()
        ]);
    }

    /**
     * Unfollow a user.
     */
    public function unfollow(User $user)
    {
        $follower = auth()->user();
        $follower->followings()->detach($user);

        return response()->json([
            'following' => false,
            'followers_count' => $user->followers()->count(),
            'followings_count' => $follower->followings()->count()
        ]);
    }

}
