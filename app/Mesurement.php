<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesurement extends Model
{
    protected $fillable = [
        'tank_id','tempC', 'ph', 'kh', 'gh', 'no3', 'ppm', 'us', 'created_at','description'
    ];

    public function tank()
    {
        return $this->belongsTo(Tank::Class);
    }
}
