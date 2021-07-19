<?php

namespace AmphiBee\Hooks\Support;

final class ClassCallbackFormatter
{
    public static function format($callback, array $args = [])
    {
        if (is_hookable($callback)) {
            return [new $callback(...$args), 'execute'];
        }

        return $callback;
    }
}
