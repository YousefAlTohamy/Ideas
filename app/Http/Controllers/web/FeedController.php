<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;


class FeedController extends Controller
{
    /**
     * display the feed page
     * get all ideas from users that an user follows
     * search for user
     */
    public function __invoke(Request $request)
    {
        $followingIDs = app('followingsIDs');
        $ideas =  Idea::whereIn('user_id', $followingIDs)->latest()->paginate(5);
        $likedIdeaIDs = auth()->check() ? auth()->user()->likes()->pluck('ideas.id') : collect();
        $users = collect();

        if (request()->has('search')) {
            $search = request()->get('search', '');
            $users = User::where('name', 'like', '%' . $search . '%')
                ->orWhere('user_name', 'like', '%' . $search . '%')
                ->get();
        }

        return view('dashboard', [
            'ideas' => $ideas,
            'users' => $users,
            'likedIdeaIDs' => $likedIdeaIDs,
        ]);
    }
}
