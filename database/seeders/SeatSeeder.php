<?php

namespace Database\Seeders;

use App\Models\Seat;
use App\Models\SeatType;
use App\Models\Table;
use App\Models\Hall;
use Illuminate\Database\Seeder;

class SeatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hall = Hall::factory()->create();
        for ($i=0; $i < 2; $i++) { 
            $seatType = SeatType::factory()->create();
            $table = Table::factory()
                ->for($hall)
                ->create();

           Seat::factory()
                ->count(70)
                ->for($seatType)
                ->for($table)
                ->create();

        }
       
    }
}
