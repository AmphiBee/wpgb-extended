<?php
namespace AmphiBee\WpgbExtended\Core\Hooks;

use AmphiBee\Hooks\Contracts\Hookable;
use AmphiBee\WpgbExtended\Models\Facet;

class ExtendedFacetArgs implements Hookable
{
    /**
     * Event name to hook on.
     */
    public $hook = 'wp_grid_builder/facet/render_args';

    private $args = [];


    /**
     * Hook Priority
     */
    public $priority = 13;

    public function __construct($args) {
        $this->args = $args;

        if (isset($args['slug'])) {
            $this->args['id'] = Facet::getBySlug($args['slug']);
        }
    }
    /**
     * The actions to perform.
     *
     * @return void
     */
    public function execute(): array
    {
        return $this->args;
    }
}
