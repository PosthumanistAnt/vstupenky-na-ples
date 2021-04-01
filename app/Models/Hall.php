<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'location',
        'description',
        'image',
        'event_id'
    ];

    public $timestamps = false;

    public function tables(){
        return $this->hasMany(Table::class);
    }

    public function event(){
        return $this->belongsTo(Event::class);
    }
}
