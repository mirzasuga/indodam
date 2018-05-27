<?php

namespace App\Services;

use App\Option as SiteOption;

/**
 * Option Class (Site Option Service).
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class Option
{
    protected $option;

    public function __construct()
    {
        $this->option = SiteOption::all();
    }

    public function get($key, $default = '')
    {
        $option = $this->option->where('key', $key)->first();
        if ($option) {
            return $option->value;
        }

        return $default;
    }

    public function set($key, string $value)
    {
        $option = $this->option->where('key', $key)->first();

        if ($option) {
            $option->value = $value;
            $option->save();
        } else {
            $option = new SiteOption();
            $option->key = $key;
            $option->value = $value;
            $option->save();
        }

        return $value;
    }
}
