<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Resources\UserResource;
use App\Jobs\SendWelcomeEmailJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user, send a welcome email, and return a token.
     */
    public function register(CreateUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'user_name' => '@' . $validated['user_name'],
            'password' => Hash::make($validated['password']),
        ]);

        // Dispatch the welcome email to the background queue
        SendWelcomeEmailJob::dispatch($user);

        // Create an API token for the new user
        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => UserResource::make($user),
            'token' => $token,
        ], 201); // 201 Created status
    }

    /**
     * Authenticate a user and return a token.
     */
    public function login(AuthenticateUserRequest $request)
    {
        $validated = $request->validated();

        if (!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401); // 401 Unauthorized status
        }

        $user = User::where('email', $validated['email'])->firstOrFail();

        $token = $user->createToken('auth-token')->plainTextToken;

        return response()->json([
            'user' => UserResource::make($user),
            'token' => $token,
        ]);
    }

    /**
     * Log the user out by revoking their current token.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent(); // 204 No Content status
    }
}
