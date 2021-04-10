<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderState;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $order_state = new OrderState;
        $order_state->state = 'pending';
        $order_state->save();

        $order_state = new OrderState;
        $order_state->state = 'accepted';
        $order_state->save();

        $order_state = new OrderState;
        $order_state->state = 'declined';
        $order_state->save();

        $this->call([
            SeatSeeder::class,
        ]);
    }
}
