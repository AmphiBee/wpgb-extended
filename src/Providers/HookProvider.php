<?php

namespace AmphiBee\WpgbExtended\Providers;

use AmphiBee\Hooks\Action;
use AmphiBee\Hooks\Filter;
use AmphiBee\WpgbExtended\Support\Facades\Config;

/**
 * @author   AmphiBee
 * @access   public
 * @version  1.0
 * @since    1.0
 */
class HookProvider
{
    /**
     * Default hooks settings.
     *
     * @var array
     */
    protected $default = [
        'hook'     => 'init',
        'priority' => 12,
    ];


    /**
     * The booting method.
     *
     * @return void
     */
    public function boot(): void
    {
        $hooks = Config::get('hooks');

        foreach ($hooks as $type => $classes) {
            foreach ($classes as $class) {
                $reflection = new \ReflectionClass($class);
                $instance   = $reflection->newInstanceWithoutConstructor();
                $args       = array_merge($this->default, get_class_vars(get_class($instance)));

                if ($type === 'filter') {
                    Filter::add($args['hook'], $class, $args['priority']);
                } else {
                    Action::add($args['hook'], $class, $args['priority']);
                }
            }
        }
    }
}
