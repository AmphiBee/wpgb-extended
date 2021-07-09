<?php
namespace AmphiBee\WpgbExtended\Providers;

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
    public static function getBySlug(string $slug) {
        $facet = Database::query_row(
            [
                'select' => 'id',
                'from'   => 'facets',
                'id'     => $slug,
            ]
        );
    }
}
