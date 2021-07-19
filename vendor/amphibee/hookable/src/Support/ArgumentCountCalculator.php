<?php

namespace AmphiBee\Hooks\Support;

use Closure;
use ReflectionClass;
use ReflectionFunction;

final class ArgumentCountCalculator
{
    private $callback;

    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    public function calculate()
    {
        if (is_hookable($this->callback)) {
            return $this->countForHookable($this->callback);
        }

        $callback = Closure::fromCallable($this->callback);

        if (! is_callable($callback)) {
            return 1;
        }

        $reflection = new ReflectionFunction($callback);

        if ($reflection->getNumberOfParameters() < 1) {
            return 1;
        }

        return (int) $reflection->getNumberOfParameters();
    }

    private function countForHookable($class)
    {
        $reflection = new ReflectionClass($class);

        if (! $reflection->getConstructor()) {
            return 1;
        }

        $number = $reflection->getConstructor()->getNumberOfParameters();

        return $number > 1 ? $number : 1;
    }

    public static function make($callback)
    {
        return new self($callback);
    }
}
