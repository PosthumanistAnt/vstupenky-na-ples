<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    public function seats(){
        return $this->hasMany(Seat::class);
    }
    public function hall(){
        return $this->belongsTo(Hall::class);
    }
}
