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
            for ($j=0; $j < 4; $j++) { 
                $table = Table::factory()
                    ->for($hall)
                    ->create();

            Seat::factory()
                    ->count(5)
                    ->for($seatType)
                    ->for($table)
                    ->create();
            }
        }
       
    }
}
