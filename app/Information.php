<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    const ABOUT = "about";
    const CONTACTS = "contacts";

    public $fillable = [
        "type", "title", "content"
    ];
}
