<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IdeaResource;
use App\Http\Resources\UserResource;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a paginated listing of ideas, or search for users.
     */
    public function index(Request $request)
    {
        // If a search term is provided, search for users and return them.
        if ($request->has('search')) {
            $search = $request->get('search', '');

            $users = User::where('name', 'like', "%{$search}%")
                ->orWhere('user_name', 'like', "%{$search}%")
                ->limit(10) // Limit the number of search results
                ->get();

            return UserResource::collection($users);
        }

        // Otherwise, return a paginated list of ideas as default.
        // The Idea model's $with and $withCount properties handle all eager loading.
        $ideas = Idea::latest()->paginate(15);

        // Return a collection of Idea resources. Laravel automatically handles pagination links.
        return IdeaResource::collection($ideas);
    }
}
