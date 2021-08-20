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
            'scroll_to_top' => 1,
        ]);
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

    /**
     * Show all of the pages instead of a short list of the pages near the current page
     * @param bool $value
     * @return $this
     */
    public function setShowAll(bool $value): PaginationFacet
    {
        $this->setSetting('show_all', (int)$value);
        return $this;
    }

    /**
     * Show all of the pages instead of a short list of the pages near the current page
     * @return bool
     */
    public function getShowAll(): bool
    {
        return (bool)$this->getSetting('show_all');
    }

    /**
     * Shortcut to show all of the pages instead of a short list of the pages near the current page
     * @return $this
     */
    public function enableShowAll(): PaginationFacet
    {
        $this->setShowAll(true);
        return $this;
    }

    /**
     * Shortcut to disable the show of all of the pages instead of a short list of the pages near the current page
     * @return $this
     */
    public function disableShowAll(): PaginationFacet
    {
        $this->setShowAll(false);
        return $this;
    }

    /**
     * Get how many numbers to either side of current page, but not including current page.
     * @return int
     */
    public function getMiddlePagesSize(): int
    {
        return $this->getSetting('mid_size');
    }

    /**
     * Set how many numbers to either side of current page, but not including current page.
     * @param int $value
     * @return $this
     */
    public function setMiddlePagesSize(int $value): PaginationFacet
    {
        $this->setSetting('mid_size', $value);
        return $this;
    }

    /**
     * Get how many numbers to either side of current page, but not including current page.
     * @return int
     */
    public function getEndPagesSize(): int
    {
        return $this->getSetting('end_size');
    }

    /**
     * Set how many numbers to either side of current page, but not including current page.
     * @param int $value
     * @return $this
     */
    public function setEndPagesSize(int $value): PaginationFacet
    {
        $this->setSetting('end_size', $value);
        return $this;
    }

    /**
     * Set the text of the dots. Default : …
     * @param string $value
     * @return $this
     */
    public function setDotText(string $value): PaginationFacet
    {
        $this->setSetting('dots_page', $value);
        return $this;
    }

    /**
     * Get the text of the dots
     * @return string
     */
    public function getDotText(): string
    {
        return $this->getSetting('dots_page');
    }

    /**
     * Set if navigation buttons must be enabled or disabled
     * @param bool $value
     * @return $this
     */
    public function setNavigationButtons(bool $value): PaginationFacet
    {
        $this->setSetting('prev_next', (int)$value);
        return $this;
    }

    /**
     * Check if navigation buttons must be enabled or disabled
     * @return int
     */
    public function getNavigationButtons(): bool
    {
        return (bool)$this->getSetting('prev_next');
    }

    /**
     * Shortcut to enable navigation buttons
     * @return $this
     */
    public function enableNavigationButton(): PaginationFacet
    {
        $this->setNavigationButtons(true);
        return $this;
    }

    /**
     * Shortcut to disable navigation buttons
     * @return $this
     */
    public function disableNavigationButtons(): PaginationFacet
    {
        $this->setNavigationButtons(false);
        return $this;
    }

    /**
     * Set the text of the previous button
     * @param string $value
     * @return $this
     */
    public function setPrevText(string $value): PaginationFacet
    {
        $this->setSetting('prev_text', $value);
        return $this;
    }

    /**
     * Get the text of the previous button
     * @return string
     */
    public function getPrevText(): string
    {
        return $this->getSetting('prev_text');
    }

    /**
     * Set the text of the next button
     * @param string $value
     * @return $this
     */
    public function setNextText(string $value): PaginationFacet
    {
        $this->setSetting('next_text', $value);
        return $this;
    }

    /**
     * Get the text of the next button
     * @return string
     */
    public function getNextText(): string
    {
        return $this->getSetting('next_text');
    }

    /**
     * Dsable or enable scroll to top at the change of the page
     * @param bool $value
     * @return $this
     */
    public function setScrollToTop(bool $value): PaginationFacet
    {
        $this->setSetting('scroll_to_top', (int)$value);
        return $this;
    }

    /**
     * Check if scroll to top at the change of the page is enabled
     * @return int
     */
    public function getScrollToTop(): bool
    {
        return (bool)$this->getSetting('scroll_to_top');
    }

    /**
     * Shortcut to enable scroll to top at the change of the page
     * @return $this
     */
    public function enableScrollToTop(): PaginationFacet
    {
        $this->setScrollToTop(true);
        return $this;
    }

    /**
     * Shortcut to disable scroll to top at the change of the page
     * @return $this
     */
    public function disableScrollToTop(): PaginationFacet
    {
        $this->setScrollToTop(false);
        return $this;
    }

}
