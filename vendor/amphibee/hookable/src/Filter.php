<?php

namespace AmphiBee\Hooks;

class Filter extends Hook
{
    public static function do(string $name, ...$args)
    {
        return call_user_func('apply_filters', $name, ...$args);
    }

    public static function apply(string $name, ...$args)
    {
        return static::do($name, ...$args);
    }
}
