<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
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
    ];

    public function seat(){
        return $this->belongsTo(Seat::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
}
