<?php

namespace AmphiBee\WpgbExtended\Models;

/**
 * Grid
 *
 * Wrapper for the Gridbuilder ᵂᴾ Grid
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */

use WP_Grid_Builder\Includes\Database;

class Grid
{
    protected static $_cached = [];

    public static function getBySlug(string $name): int
    {
        return Database::query_row(
            [
                'select' => 'id',
                'from' => 'grids',
                'name' => $name,
            ]
        );
    }
}
