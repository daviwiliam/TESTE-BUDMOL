<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserEvent extends Model
{
    /** @use HasFactory<\Database\Factories\UserEventFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'active'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
