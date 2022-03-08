<?php

namespace App\Models;

use Illuminate\Support\Arr;

abstract class ReferenceAbstract
{
    protected static $lists = [];

    
    public static function all()
    {
        return collect(static::$lists);
    }

    public static function toArray()
    {
        return static::$lists;
    }
    public static function getById($singleId)
    {
        return static::$lists[$singleId];
    }

}