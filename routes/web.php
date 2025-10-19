<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\IdeaController as AdminIdeaController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\web\CommentController;
use App\Http\Controllers\web\DashboardController;
use App\Http\Controllers\web\FeedController;
use App\Http\Controllers\web\FollowerController;
use App\Http\Controllers\web\IdeaController;
use App\Http\Controllers\web\IdeaLikeController;
use App\Http\Controllers\web\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// feed
Route::get('/feed', FeedController::class)->middleware('auth')->name('feed');

// Idea Control
Route::resource('ideas', IdeaController::class)->except(['index', 'create', 'show'])->middleware('auth');
Route::resource('ideas', IdeaController::class)->only(['show']);
Route::resource('ideas.comments', CommentController::class)->only(['store', 'destroy'])->middleware('auth');
Route::get('/ideas/{idea}/likes', [IdeaController::class, 'likes'])->name('ideas.likes');

// User Control
Route::resource('users', UserController::class)->only('show', 'edit', 'update')->middleware('auth');
Route::resource('users', UserController::class)->only('show');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('auth')->name('users.destroy');

// Profile
Route::get('/profile', [UserController::class, 'profile'])->middleware('auth')->name('profile');

// followers & followings
Route::get('/users/{user}/followers', [UserController::class, 'followers'])->name('users.followers');
Route::get('/users/{user}/followings', [UserController::class, 'followings'])->name('users.followings');

// Follow & UnFollow
Route::post('users/{user}/follow', [FollowerController::class, 'follow'])->middleware('auth')->name('users.follow');
Route::post('users/{user}/unfollow', [FollowerController::class, 'unfollow'])->middleware('auth')->name('users.unfollow');

// Likes & UnLikes
Route::post('ideas/{idea}/like', [IdeaLikeController::class, 'like'])->middleware('auth')->name('ideas.like');
Route::post('ideas/{idea}/unlike', [IdeaLikeController::class, 'unlike'])->middleware('auth')->name('ideas.unlike');


// Terms Page
Route::get('/terms', function () {
    return view('terms');
})->name('terms');


// Admin
Route::middleware(['auth', 'can:admin'])->prefix('/admin')->as('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::post('/users/{user}/toggle-admin', [AdminUserController::class, 'toggleAdmin'])->name('users.toggleAdmin');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/ideas', [AdminIdeaController::class, 'index'])->name('ideas');
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments');

    Route::get('/Admins', [AdminController::class, 'index'])->name('Admins');
});
