<?php

namespace App\Providers;

use App\Models\Office;
use App\Models\User;
use App\Models\UserRequest;
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
        View::composer(['components.layouts.app.sidebar', 'components.users.layout'], function ($view) {
            $allUsers = User::all();
            $allRequests = UserRequest::where('approved', false)->where('rejected', false)->get();
            $allOffices = Office::all();

            $view->with([
                'allUsers' => $allUsers,
                'allOffices' => $allOffices,
                'allRequests' => $allRequests,
            ]);
        });
    }
}
