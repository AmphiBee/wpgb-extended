<?php

namespace AmphiBee\WpgbExtended\Providers\Cards;

use AmphiBee\WpgbExtended\Models\Card;
use AmphiBee\WpgbExtended\Providers\ItemSync;

/**
 * Card Sync
 *
 * Sync tool for the Gridbuilder ᵂᴾ Cards
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
class CardSync extends ItemSync
{
    protected $type = 'cards';
    protected $identifier = 'name';
}
