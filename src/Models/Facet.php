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
class Facet
{
    protected static $_cached = [];

    public static function getBySlug(string $slug): int
    {
        return Database::query_row(
            [
                'select' => 'id',
                'from' => 'facets',
                'slug' => $slug,
            ]
        );
    }


    public static function getById(int $id)
    {
        return Database::query_row(
            [
                'select' => 'slug',
                'from' => 'facets',
                'id' => $id,
            ]
        );
    }
}
