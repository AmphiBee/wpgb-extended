<?php

namespace AmphiBee\WpgbExtended\Core\Hooks;

use AmphiBee\Hooks\Contracts\Hookable;
use AmphiBee\WpgbExtended\Providers\Facets\FacetSync;

class SyncSavedFacet implements Hookable
{
    public $hook = 'wp_grid_builder/save/facet';
    private $facetId = 0;
    public $priority = 13;

    public function __construct($facetId)
    {
        $this->facetId = (int)$facetId;
    }

    public function execute()
    {
        $facet = new FacetSync($this->facetId);
        $facet->save();
    }
}
