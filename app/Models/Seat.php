<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;

    public function table(){
        return $this->belongsTo(Table::class);
    }

    public function seatType(){
        return $this->belongsTo(SeatType::class);
    }
}
