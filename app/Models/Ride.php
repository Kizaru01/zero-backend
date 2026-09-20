<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    protected $fillable = [
        'pickup',
        'destination',
        'status',
        'driver_id',
        'user_id',
    ];
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
