<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Import your API controllers
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\FeedController;
use App\Http\Controllers\Api\FollowerController;
use App\Http\Controllers\Api\IdeaController;
use App\Http\Controllers\Api\IdeaLikeController;
use App\Http\Controllers\Api\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// =========================================================================
//  Public Routes (No Authentication Needed)
// =========================================================================

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Ideas (Read-Only)
Route::get('/ideas', [IdeaController::class, 'index']);
Route::get('/ideas/{idea}', [IdeaController::class, 'show']);
Route::get('/ideas/{idea}/likes', [IdeaController::class, 'likes']);

// Users (Read-Only)
Route::get('/users/{user}', [UserController::class, 'show']);
Route::get('/users/{user}/followers', [UserController::class, 'followers']);
Route::get('/users/{user}/followings', [UserController::class, 'followings']);




// =========================================================================
//  Protected Routes (Requires Authentication via Sanctum)
// =========================================================================
Route::middleware('auth:sanctum')->group(function () {

    // Authentication
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return \App\Http\Resources\UserResource::make($request->user());
    });

    // Feed
    Route::get('/feed', FeedController::class);

    // Ideas (Create, Update, Delete, view likes)
    Route::post('/ideas', [IdeaController::class, 'store']);
    Route::put('/ideas/{idea}', [IdeaController::class, 'update']);
    Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy']);

    // Comments
    Route::post('/ideas/{idea}/comments', [CommentController::class, 'store']);
    Route::delete('/ideas/{idea}/comments/{comment}', [CommentController::class, 'destroy']);

    // Likes
    Route::post('/ideas/{idea}/like', [IdeaLikeController::class, 'like']);
    Route::delete('/ideas/{idea}/unlike', [IdeaLikeController::class, 'unlike']);

    // User Profile
    Route::patch('/profile', [UserController::class, 'update']);
    Route::delete('/profile', [UserController::class, 'destroy']);

    // Follows
    Route::post('/users/{user}/follow', [FollowerController::class, 'follow']);
    Route::delete('/users/{user}/unfollow', [FollowerController::class, 'unfollow']);
});
