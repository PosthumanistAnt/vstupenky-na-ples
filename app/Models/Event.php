<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reservation_start',
        'reservation_end',
        'ball_start',
        'location',
        'description',
    ];

    protected $dates = ['reservation_start', 'reservation_end', 'ball_start'];

    public function halls(){
        return $this->hasMany(Hall::class);
    }
}
