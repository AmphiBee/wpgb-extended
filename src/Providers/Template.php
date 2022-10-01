<?php
namespace AmphiBee\WpgbExtended\Providers;

use AmphiBee\WpgbExtended\Facades\Template as TemplateFacade;
/**
* Template
*
* Wrapper for the Gridbuilder ᵂᴾ Template function (deprecated, this is not a provider, use the facade)
*
* @link    https://github.com/AmphiBee/wpgb-extended/
* @author  amphibee
* @link    https://amphibee.fr
* @version 1.0
* @license https://opensource.org/licenses/mit-license.html MIT License
*/
class Template
{
    /** @return static */
    public static function make(?string $slug = null): TemplateFacade
    {
        _deprecated_function(__METHOD__, '1.11', 'AmphiBee\WpgbExtended\Facades\Template instead');
        return new TemplateFacade($slug);
    }
}
