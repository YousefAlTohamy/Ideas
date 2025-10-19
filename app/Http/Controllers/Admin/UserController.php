<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * get all users from data DB.
     * search for users by the name, user name, or email.
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

        $users = $query->where('is_admin', false)->latest()->paginate(10);

        return view('admin.users.index',
        compact(
            'users',
            'currentRouteName'
        ));
    }


    /**
     * change the admin status
     */
    public function toggleAdmin(User $user)
    {
        // Security Check: Prevent an admin from de-activating their own admin status.
        if (auth()->user()->id === $user->id) {
            return redirect()->back()->with('error', 'You cannot change your own admin status.');
        }

        // Toggle the boolean value
        $user->is_admin = !$user->is_admin;
        $user->save();

        return redirect()->back()->with('success', 'User admin status updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     * delete a user or admin from the system
     */
    public function destroy(User $user)
    {
        $this->authorize('author', $user);

        Storage::disk('public')->delete($user->image ?? '');
        $user->delete();

        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
