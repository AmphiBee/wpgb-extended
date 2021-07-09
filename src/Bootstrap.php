<?php
namespace AmphiBee\WpgbExtended;
/**
 * Boostrap
 *
 * Loader
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */

use AmphiBee\WpgbExtended\Providers\HookProvider;

class Bootstrap
{
    public function __construct()
    {
        (new HookProvider)->boot();
    }
}

