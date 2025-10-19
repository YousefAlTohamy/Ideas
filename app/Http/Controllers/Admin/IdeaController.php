<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     * get all ideas from data DB.
     * search for ideas by the content, or the created at date for example "2025-10-45".
     */
    public function index()
    {
        $query = Idea::query();

        $currentRouteName = request()->route()->getName();

        if (request()->has('search')) {
            $searchTerm = request('search');

            $query->where(function ($q) use ($searchTerm) {
                $q->Where('content', 'like', "%{$searchTerm}%")
                    ->orWhere('created_at', 'like', "%{$searchTerm}%");
            });
        }

        $ideas = $query->latest()->paginate(10);
        return view(
            'admin.ideas.index',
            compact(
                'ideas',
                'currentRouteName'
            )
        );
    }
}
