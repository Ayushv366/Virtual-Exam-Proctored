<?php

namespace App\Providers;

use App\Models\Announcement;
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
        View::share('appTitle', config('app.name'));
        View::share('examHallTagline', 'Virtual exam hall with proctoring controls');
        View::composer('*', function ($view): void {
            // Shared data across Blade views demonstrates Unit II view sharing.
            $view->with('sharedAnnouncements', Announcement::query()->latest()->take(3)->get());
        });
    }
}
