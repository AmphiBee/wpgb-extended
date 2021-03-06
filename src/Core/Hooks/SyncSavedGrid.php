<?php

namespace AmphiBee\WpgbExtended\Core\Hooks;

use AmphiBee\Hooks\Contracts\Hookable;
use AmphiBee\WpgbExtended\Providers\Grids\GridSync;

class SyncSavedGrid implements Hookable
{
    public $hook = 'wp_grid_builder/save/grid';
    private $gridId = 0;
    public $priority = 13;

    public function __construct($gridId)
    {
        $this->gridId = (int)$gridId;
    }

    public function execute()
    {
        $grid = new GridSync($this->gridId);
        $grid->save();
    }
}
