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

        Lean::page('home', Pages\HomePage::class);
        Lean::page('tableLayout', Pages\TableLayoutPage::class);
        Lean::resource('users', Resources\UserResource::class);
        Lean::resource('messageTypes', Resources\MessageTypeResource::class);
        Lean::resource('messages', Resources\MessageResource::class);
        Lean::resource('events', Resources\EventResource::class);
        Lean::resource('halls', Resources\HallResource::class);
        Lean::resource('tables', Resources\TableResource::class);
        Lean::resource('seats', Resources\SeatResource::class);
        Lean::resource('seatTypes', Resources\SeatTypeResource::class);
        Lean::resource('reservedSeats', Resources\ReservedSeatResource::class);
        Lean::resource('orderStates', Resources\OrderStateResource::class);
        Lean::resource('orders', Resources\OrderResource::class);
        Lean::resource('settings', Resources\SettingResource::class);
    }
}
