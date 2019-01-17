<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public $fillable = [
        'name', 'description', 'layer_id',
        'latitude', 'longitude'
    ];

    public function layer()
    {
        return $this->belongsTo(Layer::class);
    }
}
