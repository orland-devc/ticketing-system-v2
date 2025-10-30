<?php

namespace App\Providers;

use App\Models\Office;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
        View::composer(['components.layouts.app.sidebar'], function ($view) {
            $allUsers = User::all();
            $allOffices = Office::all();

            $view->with([
                'allUsers' => $allUsers,
                'allOffices' => $allOffices,
            ]);
        });
    }
}
