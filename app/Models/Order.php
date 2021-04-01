<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
        
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'user_id',
        'state_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function state(){
        return $this->belongsTo(OrderState::class);
    }

}
