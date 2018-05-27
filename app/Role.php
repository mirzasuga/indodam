<?php

namespace App;

use App\ReferenceAbstract;

/**
 * Role Class
 */
class Role extends ReferenceAbstract
{
    protected static $lists = [
        1 => 'admin',
        2 => 'member',
    ];

    public static function getById($roleId)
    {
        return trans('user.'.static::$lists[$roleId]);
    }

    public static function toArray()
    {
        $lists = [];
        foreach (static::$lists as $key => $value) {
            $lists[$key] = trans('user.'.$value);
        }

        return $lists;
    }

    public static function all()
    {
        return collect($this->toArray());
    }

    public static function dropdown()
    {
        $lists = [];
        foreach (static::$lists as $key => $value) {
            $lists[$key] = strtoupper($value).' - '.trans('user.'.$value);
        }

        return $lists;
    }
}
