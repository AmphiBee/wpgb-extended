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
    protected static $_cached = [];

    public static function getBySlug(string $slug): int
    {
        self::$_cached[$slug] = self::$_cached[$slug] ?? Database::query_row(
            [
                'select' => 'id',
                'from' => 'facets',
                'slug' => $slug,
            ]
        );

        return !is_null(self::$_cached[$slug]) ? (int)self::$_cached[$slug]['id'] : 0;
    }


    public static function getById(string $id)
    {
        self::$_cached[$id] = self::$_cached[$id] ?? Database::query_row(
            [
                'select' => 'slug',
                'from' => 'facets',
                'id' => $id,
            ]
        );

        return !is_null(self::$_cached[$id]) ? self::$_cached[$id]['slug'] : false;
    }
}
