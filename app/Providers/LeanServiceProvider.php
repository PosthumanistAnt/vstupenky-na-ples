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
        Lean::addResource('messageTypes', Resources\MessageTypeResource::class);
        Lean::addResource('messages', Resources\MessageResource::class);
        Lean::addResource('halls', Resources\HallResource::class);
        Lean::addResource('tables', Resources\TableResource::class);
        Lean::addResource('seats', Resources\SeatResource::class);
        Lean::addResource('seatTypes', Resources\SeatTypeResource::class);
    }
}
