<?php
namespace AmphiBee\WpgbExtended\Providers;
/**
 * Template
 *
 * Wrapper for the Gridbuilder ᵂᴾ Template function
 *
 * @link    https://github.com/jjgrainger/PostTypes/
 * @author  jjgrainger
 * @link    https://jjgrainger.co.uk
 * @version 2.0
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
    protected $slug;
    protected $wrapperTag;

    public function __construct(?string $slug = null)
    {
        $this->setSlug($slug);
    }

    /** @return static */
    public static function make(?string $slug = null): self
    {
        return new static($slug);
    }

    /**
     * Register the template
     * @return void
     */
    public function register()
    {
        $templateArgs = $this->getTemplateArgs();
        $slug = $this->getSlug();

        // Register template
        add_filter('wp_grid_builder/templates', function () use ($slug, $templateArgs) {
            $templates[$slug] = $templateArgs;
            return $templates;
        }, 10, 1);

        // Override the wrapper tag if needed
        if ($overrideTag = $this->getWrapperTag()) {
            add_filter( 'wp_grid_builder/layout/wrapper_tag', function ($tag, $settings) use ($overrideTag, $slug) {
                if ($settings->id === $slug) {
                    $tag = $overrideTag;
                }
                return $tag;
            }, 90, 2);
        }
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
     * @param array $classes
     * @return Template
     */
    public function setClasses(array $classes): Template
    {
        $this->classes = $classes;
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
        return $this->slug;
    }

    /**
     * Set the template slug
     * @param string $slug
     * @return Template
     */
    public function setSlug(string $slug): Template
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Get the template wrapper tag
     * @return string
     */
    public function getWrapperTag(): string
    {
        return $this->wrapperTag;
    }

    /**
     * Set the template wrapper tag
     * @param string $wrapperTag
     * @return Template
     */
    public function setWrapperTag(string $wrapperTag): Template
    {
        $this->wrapperTag = $wrapperTag;
        return $this;
    }

}
