<?php

namespace AmphiBee\WpgbExtended\Core\Hooks;

use AmphiBee\Hooks\Contracts\Hookable;
use AmphiBee\WpgbExtended\Providers\Cards\CardSync;
use AmphiBee\WpgbExtended\Providers\Facets\FacetSync;
use AmphiBee\WpgbExtended\Providers\Grids\GridSync;

class SyncManager implements Hookable
{
    public $hook = 'wp_grid_builder/init';
    public $priority = 10;

    public function execute()
    {
        // facet sync
        (new FacetSync())->importOrUpdate();

        // grid sync
        (new GridSync())->importOrUpdate();

        // card sync
        (new CardSync())->importOrUpdate();
    }
}

