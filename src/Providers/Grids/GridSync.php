<?php

namespace AmphiBee\WpgbExtended\Providers\Grids;

use AmphiBee\WpgbExtended\Models\Grid;
use AmphiBee\WpgbExtended\Providers\ItemSync;

/**
 * Grid Sync
 *
 * Sync tool for the Gridbuilder ᵂᴾ Grids
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
class GridSync extends ItemSync
{
    protected $type = 'grids';

    /**
     * Get the grid item in the database
     */
    protected function getItem(object $jsonSettings)
    {
        $name = $jsonSettings->{$this->type}[0]->name;
        return Grid::getByName($name);
    }
}
