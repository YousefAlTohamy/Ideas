<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthenticateUserRequest;
use App\Http\Requests\CreateUserRequest;
use App\Jobs\SendWelcomeEmailJob;
use App\Mail\WelcomeEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * display the register page
     */
    public function register()
    {
        return view('auth.register', ['hideFooter' => true]);
    }

    /**
     * Register a new user, and send a welcome email
     */
    public function store(CreateUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create(
            [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'user_name' => '@' . $validated['user_name'],
                'password' => Hash::make($validated['password']),
            ]
        );

        SendWelcomeEmailJob::dispatch($user);

        return redirect()->route('login')->with('success', 'Account created successfully!!');
    }

    /**
     * display the login page
     */
    public function login()
    {
        return view('auth.login', ['hideFooter' => true]);
    }

    /**
     * Authenticate a user
     */
    public function authenticate(AuthenticateUserRequest $request)
    {
        $validated = $request->validated();

        if (auth()->attempt($validated)) {
            request()->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
        }


        return redirect()->route('login')->withErrors([
            'email' => "No matching user found with the provided email and password"
        ]);
    }

    /**
     * logout
     */
    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()->route('dashboard')->with('success', 'Logged out successfully!');
    }
}
