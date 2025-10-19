<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class UserController extends Controller
{
    /**
     * Display the specified user's profile.
     * Corresponds to GET /api/users/{user}
     */
    public function show(User $user)
    {
        // Eager load the counts and the user's ideas for a full profile view
        $user->loadCount(['ideas', 'comments', 'likes', 'followers', 'followings']);
        $user->load('ideas');

        return UserResource::make($user);
    }

    /**
     * Update the authenticated user's profile.
     * Corresponds to PATCH /api/profile
     */
    public function update(UpdateUserRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $manager = ImageManager::gd();
            $imageFile = $request->file('image');
            $image = $manager->read($imageFile)->cover(300, 300)->toJpeg(80);
            $filename = 'profile/' . Str::uuid() . '.' . $imageFile->getClientOriginalExtension();
            Storage::disk('public')->put($filename, $image);
            Storage::disk('public')->delete($user->image ?? '');
            $validated['image'] = $filename;
        } elseif ($request->input('remove_image') == '1') {
            Storage::disk('public')->delete($user->image ?? '');
            $validated['image'] = null;
        }

        $user->update($validated);

        return UserResource::make($user);
    }

    /**
     * Display a list of the user's followers.
     * Corresponds to GET /api/users/{user}/followers
     */
    public function followers(User $user)
    {
        $followers = $user->followers()->paginate(15);
        return UserResource::collection($followers);
    }

    /**
     * Display a list of the users someone is following.
     * Corresponds to GET /api/users/{user}/followings
     */
    public function followings(User $user)
    {
        $followings = $user->followings()->paginate(15);
        return UserResource::collection($followings);
    }

    /**
     * Delete the authenticated user's account.
     * Corresponds to DELETE /api/profile
     */
    public function destroy(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        Storage::disk('public')->delete($user->image ?? '');
        $user->delete(); // Assumes cascade deletes are set up in the database
        return response()->noContent();
    }
}
