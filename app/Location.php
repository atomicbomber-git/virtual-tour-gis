<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $fillable = [
        'name', 'address', 'description', 'layer_id',
        'latitude', 'longitude'
    ];

    public function layer()
    {
        return $this->belongsTo(Layer::class);
    }

    public function panoramas()
    {
        return $this->hasMany(Panorama::class);
    }
}
