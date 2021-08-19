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
abstract class Facet
{
    protected $slug = '';
    protected $name = '';
    protected $favorite = 0;
    protected $type = '';
    protected $source = '';
    protected $settings = [];
    public static $facets = [];

    /**
     * Get the facet slug
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * Set the facet slug
     * @param string $slug
     * @return Facet
     */
    public function setSlug(string $slug): Facet
    {
        $this->slug = $slug;
        $this->setSetting('slug', $slug);
        return $this;
    }

    /**
     * Get the facet name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set the facet name
     * @param string $name
     * @return Facet
     */
    public function setName(string $name): Facet
    {
        $this->name = $name;
        $this->setSetting('name', $name);
        return $this;
    }

    /**
     * Check if it's a favorite facet
     * @return int
     */
    public function getFavorite(): int
    {
        return $this->favorite;
    }

    /**
     * Set a facet as favorite
     * @param int $favorite
     * @return Facet
     */
    public function setFavorite(int $favorite): Facet
    {
        $this->favorite = $favorite;
        return $this;
    }

    /**
     * Get the facet type
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set the facet type
     * @param string $type
     * @return Facet
     */
    public function setType(string $type): Facet
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get the data source
     * @return string
     */
    public function getSource(): string
    {
        return $this->source;
    }

    /**
     * Set the data source
     * @param string $source
     * @return Facet
     */
    public function setSource(string $source): Facet
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Get the facet settings
     * @return array
     */
    public function getSettings(): array
    {
        return $this->settings;
    }

    /**
     * Set the facet settings
     * @param array $settings
     * @return Facet
     */
    public function setSettings(array $settings): Facet
    {
        $this->settings = $settings;
        return $this;
    }

    /**
     * Merge current facet settings
     * @param array $settings
     * @return Facet
     */
    public function mergeSettings(array $settings): Facet
    {
        $this->settings = array_merge($settings, $this->settings);
        return $this;
    }

    /**
     * Get a specific setting
     * @param string $label
     * @return false|mixed
     */
    public function getSetting(string $label)
    {
        return $this->settings[$label] ?? false;
    }

    /**
     * Set a specific setting
     * @param string $label
     * @param mixed $setting
     * @return Facet
     */
    public function setSetting(string $label, $setting): Facet
    {
        $this->settings[$label] = $setting;
        return $this;
    }

    /**
     * Set the pagination action
     * @param string $value
     * @return $this
     */
    protected function setAction(string $value): PaginationFacet
    {
        $this->setSetting('action', $value);
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->getSetting('action');
    }

    /**
     * Register the facet
     * @return void
     */
    public function register()
    {
        self::$facets[] = $this;
        echo '<pre>';
        var_dump($this);
        die();
    }
}
