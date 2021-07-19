<?php

namespace AmphiBee\Hooks;

use Closure;
use AmphiBee\Hooks\Contracts\Hook as HookContract;
use AmphiBee\Hooks\Support\ArgumentCountCalculator;
use AmphiBee\Hooks\Support\ClassCallbackFormatter;

abstract class Hook implements HookContract
{
    protected ?string $name;

    protected $initialCallback;

    protected array $callbacks = [];

    protected int $priority = 10;

    final public function __construct(string $name = null, $callback = null, int $priority = 10)
    {
        $this->setName($name);
        $this->setInitialCallback($callback);
        $this->setPriority($priority);
    }

    public static function add(string $name, $callback, int $priority = 10): HookContract
    {
        return new static($name, $callback, $priority);
    }

    public static function remove(string $name, callable $callback, int $priority = 10): bool
    {
        return call_user_func('remove_filter', $name, $callback, $priority);
    }

    public function setName(?string $name): HookContract
    {
        $this->name = $name;

        return $this;
    }

    public function setInitialCallback($callback): HookContract
    {
        $this->initialCallback = $callback;

        return $this;
    }

    public function setPriority(?int $priority): HookContract
    {
        $this->priority = $priority;

        return $this;
    }

    public function then(callable $callback): HookContract
    {
        $this->callbacks[] = Closure::fromCallable($callback);

        return $this;
    }

    public function __destruct()
    {
        $callable = function (...$args) {
            $result = call_user_func_array(
                ClassCallbackFormatter::format($this->initialCallback, $args),
                $args
            );

            foreach ($this->callbacks as $callback) {
                $callbackArgs = array_merge([$result], $args);

                $result = call_user_func_array(
                    ClassCallbackFormatter::format($callback, $callbackArgs),
                    array_slice(
                        $callbackArgs,
                        0,
                        ArgumentCountCalculator::make($callback)->calculate()
                    )
                );
            }

            return $result;
        };

        call_user_func(
            'add_filter',
            $this->name,
            $callable,
            $this->priority,
            ArgumentCountCalculator::make($this->initialCallback)->calculate()
        );
    }
}
