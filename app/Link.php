<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public $fillable = [
        'heading', 'origin_id', 'destination_id'
    ];

    public function destination()
    {
        return $this->belongsTo(Panorama::class, 'destination_id');
    }
}
