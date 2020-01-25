<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tank extends Model
{
    protected $fillable = [
        'user_id', 'name', 'capacity', 'number', 'status', 'description', 'started_at', 'shrimps'
    ];

    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    public function measurement()
    {
        return $this->hasMany(Measurement::Class);
    }
}
