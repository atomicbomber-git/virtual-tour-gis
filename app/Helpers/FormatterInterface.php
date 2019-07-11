<?php

namespace App\Helpers;

interface FormatterInterface
{
    public function date($value): string;
}
