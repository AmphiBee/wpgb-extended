<?php

namespace AmphiBee\WpgbExtended\Providers\Facets;

use AmphiBee\WpgbExtended\Models\Facet;
use AmphiBee\WpgbExtended\Providers\ItemSync;

/**
 * Facet Sync
 *
 * Sync tool for the Gridbuilder ᵂᴾ Facets
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
class FacetSync extends ItemSync
{
    protected $type = 'facets';
    protected $identifier = 'slug';
}
