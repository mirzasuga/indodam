<?php

namespace App;

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

    public static function only(array $singleIds)
    {
        return Arr::only(static::$lists, $singleIds);
    }

    public static function except($singleId)
    {
        return Arr::except(static::$lists, [$singleId]);
    }
}
