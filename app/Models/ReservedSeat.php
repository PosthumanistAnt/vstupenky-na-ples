<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservedSeat extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'seat_id',
        'created_at',
        'updated_at',
    ];

    public function seat(){
        return $this->belongsTo(Seat::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
