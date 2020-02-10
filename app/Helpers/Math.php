<?php


namespace App\Helpers;


class Math
{
    public static function fmod($x, $y)
    {
        return fmod((fmod($x, $y) + $y), $y);
    }
}