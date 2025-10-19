<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * get the number of [users, admins, ideas, comments] from data DB.
     */
    public function index()
    {
        $totalUsers = User::where('is_admin', false)->count();
        $totalAdmins = User::where('is_admin', true)->count();
        $totalIdeas = Idea::count();
        $totalComments = Comment::count();
        return view(
            'admin.dashboard',
            compact('totalUsers', 'totalAdmins', 'totalIdeas', 'totalComments')
        );
    }
}
