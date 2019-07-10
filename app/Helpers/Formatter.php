<?php

namespace App\Helpers;

use Carbon\Carbon;

class Formatter
{
    public static function date(\Carbon\Carbon $value) {
        return (new Carbon($value))->format("Y-m-d");
    }
}
