<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number',
        'description',
        'table_id',
        'seat_type_id',
    ];
        
    public function table(){
        return $this->belongsTo(Table::class);
    }

    public function seatType(){
        return $this->belongsTo(SeatType::class);
    }
}
