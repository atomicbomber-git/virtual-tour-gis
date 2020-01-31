<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $guarded = [];

    public function layer()
    {
        return $this->belongsTo(Layer::class, (new Layer)->getKeyName());
    }

    public function panoramas()
    {
        return $this->hasMany(Panorama::class);
    }
}
