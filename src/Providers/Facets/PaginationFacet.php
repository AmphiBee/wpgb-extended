<?php

namespace AmphiBee\WpgbExtended\Providers\Facets;

/**
 * Pagination Facet
 *
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
class PaginationFacet extends LoadFacet
{
    protected $type = 'pagination';

    public function __construct()
    {
        parent::__construct();

        $this->mergeSettings([
            'title' => '',
            'pagination' => 'numbered',
            'load_type' => 'pagination',
            'show_all' => 0,
            'mid_size' => 2,
            'end_size' => 2,
            'prev_next' => 0,
            'prev_text' => __('&laquo; Previous', 'wp-grid-builder'),
            'next_text' => __('Next &raquo;', 'wp-grid-builder'),
            'dots_page' => '&hellip;',
            'scroll_to_top' => 0,
        ]);
    }

    /**
     * Show all of the pages instead of a short list of the pages near the current page
     * @param int $value Possible values : 0|1
     * @return $this
     */
    public function setShowAll(int $value): PaginationFacet
    {
        $this->setSetting('show_all', $value);
        return $this;
    }

    /**
     * Get the pagination type
     * @return string
     */
    public function getShowAll(): int
    {
        return $this->getSetting('show_all');
    }

    /**
     * Get the pagination type
     * @return string
     */
    public function getPaginationType(): string
    {
        return $this->getSetting('pagination');
    }

    /**
     * Set the type of pagination
     * @param string $value Possible values : numbered|prev_next
     * @return $this
     */
    public function setPaginationType(string $value): PaginationFacet
    {
        $this->setSetting('pagination', $value);
        return $this;
    }
}
