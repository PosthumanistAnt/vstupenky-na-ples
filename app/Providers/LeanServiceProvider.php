<?php

namespace App\Providers;

use App\Lean\Pages;
use App\Lean\Resources;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Lean\Lean;

class LeanServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        Gate::define('accessLean', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });

        Lean::addPage('home', Pages\Welcome::class);
        Lean::addResource('users', Resources\UserResource::class);
    }
}
