<?php

namespace App\Helpers;

use Jenssegers\Date\Date;

class Formatter implements FormatterInterface
{
    public function date($value): string {
        return (new Date($value))->format("l, j F Y");
    }
}
