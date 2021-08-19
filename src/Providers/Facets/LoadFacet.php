<?php

namespace AmphiBee\WpgbExtended\Providers\Facets;

/**
 * Facet register class
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
abstract class LoadFacet extends Facet
{
    public function __construct() {
        $this->setAction('load');
    }

    /**
     * Set the load type
     * @param string $loadType Possible values : pagination|load_more|per_page|result_count
     * @return $this
     */
    public function setLoadType(string $loadType): LoadFacet
    {
        $this->setSetting('load_type', $loadType);
        return $this;
    }
}
