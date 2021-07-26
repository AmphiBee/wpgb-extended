<?php

namespace AmphiBee\WpgbExtended\Core\Hooks;

use AmphiBee\Hooks\Contracts\Hookable;
use AmphiBee\WpgbExtended\Providers\FacetSync;
use AmphiBee\WpgbExtended\Providers\Filemanager;

class SyncManager implements Hookable
{
    /**
     * Event name to hook on.
     */
    public $hook = 'init';

    /**
     * Hook Priority
     */
    public $priority = 10;

    /**
     * The actions to perform.
     *
     * @return void
     */
    public function execute()
    {
        $facetFs = new Filemanager('facets');
        if ($facetFs->needToSync()) {
            (new FacetSync())->importOrUpdate();
        }
    }
}
