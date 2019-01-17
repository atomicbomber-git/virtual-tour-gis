<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layer extends Model
{
    public $fillable = [
        'name', 'description'
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
