<?php
namespace AmphiBee\WpgbExtended\Models;

/**
 * Card
 *
 * Wrapper for the Gridbuilder ᵂᴾ Cards
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */

use WP_Grid_Builder\Includes\Database;

class Card
{
    protected static $_cached = [];

    public static function getBySlug(string $name): int
    {
        self::$_cached[$name] = self::$_cached[$name] ?? Database::query_row(
            [
                'select' => 'id',
                'from' => 'cards',
                'name' => $name,
            ]
        );

        return !is_null(self::$_cached[$name]) ? (int)self::$_cached[$name]['id'] : 0;
    }
}
