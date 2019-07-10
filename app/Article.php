<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    const SHORT_CONTENT_MAX_CHAR_LEN = 200;

    public $fillable = [
        "title", "content",
    ];

    public function getShortContentAttribute()
    {
        return Str::limit(strip_tags($this->content), self::SHORT_CONTENT_MAX_CHAR_LEN);
    }
}
