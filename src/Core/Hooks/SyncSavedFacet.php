<?php

namespace AmphiBee\WpgbExtended\Core\Hooks;

use AmphiBee\Hooks\Contracts\Hookable;
use AmphiBee\WpgbExtended\Providers\FacetSync;

class SyncSavedFacet implements Hookable
{
    /**
     * Event name to hook on.
     */
    public $hook = 'wp_grid_builder/save/facet';

    private $facetId = 0;


    /**
     * Hook Priority
     */
    public $priority = 13;

    public function __construct($facetId)
    {
        $this->facetId = (int)$facetId;
    }

    /**
     * The actions to perform.
     *
     * @return void
     */
    public function execute()
    {
        $facet = new FacetSync($this->facetId);
        $facet->save();
    }
}
