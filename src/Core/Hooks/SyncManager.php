<?php

namespace AmphiBee\WpgbExtended\Core\Hooks;

use AmphiBee\Hooks\Contracts\Hookable;
use AmphiBee\WpgbExtended\Providers\Cards\CardSync;
use AmphiBee\WpgbExtended\Providers\Facets\FacetSync;
use AmphiBee\WpgbExtended\Providers\Grids\GridSync;
use AmphiBee\WpgbExtended\Providers\Filemanager;

class SyncManager implements Hookable
{
    public $hook = 'init';
    public $priority = 10;

    public function execute()
    {
        $facetFs = new Filemanager('facets');

        // facet sync
        if ($facetFs->needToSync()) {
            (new FacetSync())->importOrUpdate();
        }

        // grid sync
        $gridFs = new Filemanager('grids');
        if ($gridFs->needToSync()) {
            (new GridSync())->importOrUpdate();
        }

        // card sync
        $cardFs = new Filemanager('cards');
        if ($cardFs->needToSync()) {
            (new CardSync())->importOrUpdate();
        }
    }
}

