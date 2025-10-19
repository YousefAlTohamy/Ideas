<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * get a user and the some information related to him
     */
    public function show(User $user)
    {
        $user->loadCount(['ideas', 'comments', 'likes', 'followers', 'followings']);

        $ideas = $user->ideas()->with(['comments.user'])->paginate(5);

        $likedIdeaIDs = auth()->check() ? auth()->user()->likes()->pluck('ideas.id') : collect();

        $followers_Count = $user->followers()->count();
        $followings_Count = $user->followings()->count();

        return view('users.show', [
            'user' => $user,
            'ideas' => $ideas,
            'likedIdeaIDs' => $likedIdeaIDs,
            'followers_Count' => $followers_Count,
            'followings_Count' => $followings_Count
        ]);
    }

    /**
     * display the user's edit page.
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        $editing = true;

        return view('users.edit', compact('user', 'editing'));
    }

    /**
     * update the user information.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            // 1. Create an instance of the ImageManager with the GD driver
            $manager = ImageManager::gd();

            // 2. Get the uploaded file
            $imageFile = $request->file('image');

            // 3. Read the image data from the uploaded file
            $image = $manager->read($imageFile);

            // 4. Resize and crop the image to a 300x300 square
            $image->cover(300, 300);

            // 5. Encode the image as a JPG with 80% quality
            $encodedImage = $image->toJpeg(80);

            // 6. Create a unique filename
            $filename = 'profile/' . Str::uuid() . '.' . $imageFile->getClientOriginalExtension();

            // 7. Save the new, smaller image to storage
            Storage::disk('public')->put($filename, $encodedImage);

            // 8. Delete the old image file from storage
            Storage::disk('public')->delete($user->image ?? '');

            // 9. Update the database with the new image path
            $validated['image'] = $filename;
        } elseif ($request->input('remove_image') == '1') {
            Storage::disk('public')->delete($user->image ?? '');
            $validated['image'] = null;
        }

        $user->update($validated);

        return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * display the profile page of user.
     */
    public function profile()
    {

        $user = auth()->user();
        return $this->show($user);
    }

    // display the followers of the user
    public function followers(User $user)
    {
        $followers = $user->followers()->withCount('followers')->orderBy('name')->get();

        return view('users.shared.followers', [
            'users' => $followers,
            'userName' => $user->name,
        ]);
    }

    // display the followings of the user
    public function followings(User $user)
    {
        $following = $user->followings()->withCount('followers')->orderBy('name')->get();

        return view('users.shared.following', [
            'users' => $following,
            'userName' => $user->name,
        ]);
    }

    // delete user
    public function destroy(User $user)
    {
        $this->authorize('author', $user);

        Storage::disk('public')->delete($user->image ?? '');
        $user->delete();

        return redirect()->route('dashboard')->with('success', 'User deleted successfully!');
    }
}
