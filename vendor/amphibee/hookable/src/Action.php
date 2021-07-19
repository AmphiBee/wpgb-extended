<?php

namespace AmphiBee\Hooks;

class Action extends Hook
{
    public static function do(string $name, ...$args)
    {
        return call_user_func('do_action', $name, ...$args);
    }
}
