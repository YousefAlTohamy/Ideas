<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();


        $topUsers = User::withCount('ideas')
            ->orderBy('ideas_count', 'DESC')
            ->limit(5)->get();

        View::share([
            'topUsers' => $topUsers,
        ]);

        // Use the 'singleton' method to ensure this logic runs only ONCE per request.
        $this->app->singleton('followingsIDs', function ($app) {
            return auth()->check() ? auth()->user()->followings()->pluck('user_id') : collect();
        });

        // Share the data from the container with all views.
        View::composer('*', function ($view) {
            $view->with('followingsIDs', app('followingsIDs'));
        });
    }
}
