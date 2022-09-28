<?php

namespace AmphiBee\WpgbExtended\Models;

/**
 * Getter
 *
 * Abstract class for querying Gridbuilder ᵂᴾ database
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */

use WP_Grid_Builder\Includes\Database as WpgbDatabase;

abstract class Database
{
    protected static $_cached = [];
    protected static $table;

    public static function query_row(array $args)
    {
        $hash = self::getArgumentHash($args);
        self::$_cached[$hash] = self::$_cached[$hash] ?? WpgbDatabase::query_row($args);
        return !is_null(self::$_cached[$hash]) ? self::$_cached[$hash][$args['select']] : 0;
    }

    protected static function getArgumentHash(array $args)
    {
        return md5(serialize($args));
    }
}
