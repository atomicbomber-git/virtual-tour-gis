<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    public $guarded = [];

    public function destination()
    {
        return $this->belongsTo(Panorama::class, 'destination_id');
    }
}
