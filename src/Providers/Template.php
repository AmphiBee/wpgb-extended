<?php

namespace AmphiBee\WpgbExtended\Providers;

use AmphiBee\Hooks\Filter;

/**
 * Template
 *
 * Wrapper for the Gridbuilder ᵂᴾ Template function
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
class Template
{
    protected $classes = [];
    protected $sourceType = 'post_type';
    protected $isMainQuery = false;
    protected $renderCallback;
    protected $noResultsCallback;
    protected $queryArgs = [];
    protected static $slug;
    protected static $wrapperTag = 'div';

    public function __construct(?string $slug = null)
    {
        // Register template
        Filter::add('wp_grid_builder/templates', function ($templates) use ($slug) {
            $templateArgs = $this->getTemplateArgs();
            $templates[$slug] = $templateArgs;
            return $templates;
        }, 10, 1);

        // Override the wrapper tag if needed

        Filter::add('wp_grid_builder/layout/wrapper_tag', function ($tag, $settings) use ($slug) {
            if ($settings->id === $slug && self::$wrapperTag !== 'div') {
                $tag = self::$wrapperTag;
            }
            return $tag;
        }, 90, 2);

    }

    /** @return static */
    public static function make(?string $slug = null): self
    {
        return new static($slug);
    }

    /**
     * Register the template
     * @return void
     * @deprecated 1.1
     */
    public function register()
    {
        _deprecated_function(__METHOD__, '1.1');
    }

    /**
     * Get the template arguments
     * @return array
     */
    public function getTemplateArgs(): array
    {
        return [
            'class' => implode(' ', $this->getClasses()),
            'source_type' => $this->getSourceType(),
            'query_args' => $this->getQueryArgs(),
            'is_main_query' => $this->getIsMainQuery(),
            'render_callback' => $this->getRenderCallback(),
            'noresults_callback' => $this->getNoResultsCallback(),
        ];
    }

    /**
     * Get the wrapper classes
     * @return array
     */
    public function getClasses(): array
    {
        return $this->classes;
    }

    /**
     * Set the wrapper classes
     * @param string|array $classes
     * @return Template
     */
    public function setClasses($classes): Template
    {
        $this->classes = is_array($classes) ? $classes : (array)$classes;
        return $this;
    }

    /**
     * Get the query source type
     * @return string
     */
    public function getSourceType(): string
    {
        return $this->sourceType;
    }

    /**
     * Set the query source type
     * @param string $sourceType
     * @return Template
     */
    public function setSourceType(string $sourceType): Template
    {
        $this->sourceType = $sourceType;
        return $this;
    }

    /**
     * Get if current template use the main query
     * @return bool
     */
    public function getIsMainQuery(): bool
    {
        return $this->isMainQuery;
    }

    /**
     * Set if current template must use the main query
     * @param bool $isMainQuery
     * @return Template
     */
    public function setIsMainQuery(bool $isMainQuery): Template
    {
        $this->isMainQuery = $isMainQuery;
        return $this;
    }

    /**
     * Get the render callback
     * @return mixed
     */
    public function getRenderCallback()
    {
        return $this->renderCallback;
    }

    /**
     * Set the render callback
     * @param mixed $renderCallback
     * @return Template
     */
    public function setRenderCallback($renderCallback): Template
    {
        $this->renderCallback = $renderCallback;
        return $this;
    }

    /**
     * Get the "no result" callback
     * @return mixed
     */
    public function getNoResultsCallback()
    {
        return $this->noResultsCallback;
    }

    /**
     * Set the "no result" callback
     * @param mixed $noResultsCallback
     * @return Template
     */
    public function setNoResultsCallback($noResultsCallback): Template
    {
        $this->noResultsCallback = $noResultsCallback;
        return $this;
    }

    /**
     * Get the query arguments
     * @return array
     */
    public function getQueryArgs(): array
    {
        return $this->queryArgs;
    }

    /**
     * Set the query arguments
     * @param array $queryArgs
     * @return Template
     */
    public function setQueryArgs(array $queryArgs): Template
    {
        $this->queryArgs = $queryArgs;
        return $this;
    }

    /**
     * Get the template slug
     * @return string
     */
    public function getSlug(): string
    {
        return self::$slug;
    }

    /**
     * Set the template slug
     * @param string $slug
     * @return Template
     */
    public function setSlug(string $slug): Template
    {
        self::$slug = $slug;
        return $this;
    }

    /**
     * Get the template wrapper tag
     * @return string
     */
    public function getWrapperTag(): string
    {
        return self::$wrapperTag;
    }

    /**
     * Set the template wrapper tag
     * @param string $wrapperTag
     * @return Template
     */
    public function setWrapperTag(string $wrapperTag): Template
    {
        self::$wrapperTag = $wrapperTag;
        return $this;
    }

}
