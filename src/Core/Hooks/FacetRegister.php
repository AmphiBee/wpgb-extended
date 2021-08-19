<?php

namespace AmphiBee\WpgbExtended\Core\Hooks;

use AmphiBee\Hooks\Contracts\Hookable;
use AmphiBee\WpgbExtended\Providers\Facets\Facet;

class FacetRegister implements Hookable
{
    public $hook = 'wp_grid_builder/loaded';
    public $priority = 10;

    public function execute()
    {
        var_dump(Facet::$facets);
    }
}

