<?php

namespace AmphiBee\Hooks\Support;

use AmphiBee\Hooks\Contracts\Hookable;
use ReflectionClass;

if (! function_exists('is_hookable')) {
    function is_hookable($callback): bool
    {
        return is_string($callback) && class_exists($callback) && (new ReflectionClass($callback))->implementsInterface(Hookable::class);
    }
}
