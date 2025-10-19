<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    /**
     * display the dashboard page
     * get all ideas in the app
     * search for user
     */
    public function index()
    {
        $ideas =  Idea::latest()->paginate(5);
        $users = collect();
        $likedIdeaIDs = auth()->check() ? auth()->user()->likes()->pluck('ideas.id') : collect();


        if (request()->has('search')) {
            $search = request()->get('search', '');
            $users = User::where('name', 'like', $search . '%')
                ->orWhere('user_name', 'like', $search . '%')
                ->get();
        }

        return view('dashboard', [
            'ideas' => $ideas,
            'users' => $users,
            'likedIdeaIDs' => $likedIdeaIDs,
        ]);
    }
}
