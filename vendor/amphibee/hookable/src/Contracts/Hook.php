<?php

namespace AmphiBee\Hooks\Contracts;

interface Hook
{
    public static function add(string $name, callable $callback, int $priority = 10): Hook;
    public static function do(string $name, ...$args);
    public static function remove(string $name, callable $callback, int $priority = 10): bool;
    public function then(callable $callback): Hook;
}
