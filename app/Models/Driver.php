<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'name',
        'status',
    ];
    public function rides()
    {
        return $this->hasMany(Ride::class);
    }
}
