<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shrimp extends Model
{
    protected $fillable = [
        'type', 'name', 'description'
    ];

    public function user()
    {
        return $this->belongsToMany(User::Class);
    }

    public function tank()
    {
        return $this->belongsToMany(Tank::Class);
    }
}
