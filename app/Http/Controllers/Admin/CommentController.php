<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     * get all comments from data DB.
     * search for comments by the content, or the created at date for example "2025-10-45".
     */
    public function index()
    {
        $query = Comment::query();


        $currentRouteName = request()->route()->getName();

        if (request()->has('search')) {
            $searchTerm = request('search');

            $query->where(function ($q) use ($searchTerm) {
                $q->Where('content', 'like', "%{$searchTerm}%")
                    ->orWhere('created_at', 'like', "%{$searchTerm}%");
            });
        }

        $comments = $query->with([
            'user:id,name',
            'idea.user:id'
        ])->latest()->paginate(10);


        return view(
            'admin.comments.index',
            compact(
                'comments',
                'currentRouteName'
            )
        );
    }
}
