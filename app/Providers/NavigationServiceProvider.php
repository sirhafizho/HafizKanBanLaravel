<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class NavigationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Define a view composer for the navigation view
        View::composer('layouts.navigation', function ($view) {
            // Load the $workspaces variable and pass it to the view
            $workspaces = auth()->user()->workspaces;
            $view->with('workspaces', $workspaces);
        });
    }
}
