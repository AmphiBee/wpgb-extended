<?php
namespace AmphiBee\WpgbExtended\Models;

/**
 * Facet
 *
 * Wrapper for the Gridbuilder ᵂᴾ Facets
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */

use WP_Grid_Builder\Includes\Database;

class Facet
{
    public static function getBySlug(string $slug): int
    {
        $facet = Database::query_row(
            [
                'select' => 'id',
                'from' => 'facets',
                'slug' => $slug,
            ]
        );

        return !is_null($facet) ? (int)$facet['id'] : 0;
    }
}
