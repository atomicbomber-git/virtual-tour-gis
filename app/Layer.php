<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Layer extends Model implements HasMedia
{
    use HasMediaTrait;

    public $fillable = [
        'name', 'description'
    ];

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
