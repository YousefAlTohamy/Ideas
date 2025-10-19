<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IdeaResource;
use App\Http\Resources\UserResource;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;

class FeedController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * Returns a paginated list of ideas from followed users,
     * or a list of users if a search term is provided.
     */
    public function __invoke(Request $request)
    {
        // If a search term is provided, search for users and return them.
        if ($request->has('search')) {
            $search = $request->get('search', '');

            $users = User::where('name', 'like', "%{$search}%")
                ->orWhere('user_name', 'like', "%{$search}%")
                ->limit(10)
                ->get();

            return UserResource::collection($users);
        }

        // Get the IDs of users the authenticated user is following.
        $followingIDs = $request->user()->followings()->pluck('user_id');

        // Fetch the ideas from those users.
        // The Idea model's $with and $withCount properties handle all eager loading automatically.
        $ideas = Idea::whereIn('user_id', $followingIDs)->latest()->paginate(15);

        // Return a paginated collection of Idea resources.
        return IdeaResource::collection($ideas);
    }
}
