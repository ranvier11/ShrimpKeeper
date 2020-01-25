<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesurement extends Model
{
    protected $fillable = [
        'tempC', 'ph', 'kh', 'gh', 'no3', 'ppm', 'us', 'description'
    ];

    public function tank()
    {
        return $this->belongsTo(Tank::Class);
    }
}
