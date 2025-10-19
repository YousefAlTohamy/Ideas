<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * get all admins from data DB.
     * search for admins by the name, user name, or email.
     */
    public function index()
    {
        $query = User::query();
        $currentRouteName = request()->route()->getName();

        if (request()->has('search')) {
            $searchTerm = request('search');

            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "{$searchTerm}%")
                    ->orWhere('user_name', 'like', "{$searchTerm}%")
                    ->orWhere('email', 'like', "{$searchTerm}%");
            });
        }

        $users = $query->where('is_admin', true)->latest()->paginate(10);

        return view(
            'admin.admins.index',
            compact(
                'users',
                'currentRouteName'
            )
        );
    }
}
