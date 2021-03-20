<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'message',
        'message_type_id',
        'created_at',
        'updated_at',
    ];

    protected $guarded = [];

    public function messageType(){
        return $this->belongsTo(MessageType::class);
    }
}
