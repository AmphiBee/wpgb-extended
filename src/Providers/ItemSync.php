<?php

namespace AmphiBee\WpgbExtended\Providers;

use AmphiBee\WpgbExtended\Providers\Filemanager;
use WP_Grid_Builder\Admin\Export;
use WP_Grid_Builder\Includes\Database;

/**
 * Item Sync
 *
 * Sync tool for the Gridbuilder ᵂᴾ
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
abstract class ItemSync
{
    private $itemId = 0;
    protected $type;
    protected $fs;

    public function __construct(int $itemId = 0)
    {
        $this->fs = new Filemanager($this->type);
        $this->itemId = $itemId;
        if ($this->isSyncEnabled()) {
            return;
        }
    }

    /**
     * Check if sync is enabled for the required item
     * @return bool
     */
    public function isSyncEnabled(): bool
    {
        return apply_filters('wpgb_extended/enable_sync', true) && apply_filters("wpgb/{$this->type}/enable_sync", true);
    }

    /**
     * Shortcut for the export method
     */
    public function save()
    {
        $this->export();
    }

    /**
     * Maybe import or create item within the database
     */
    public function importOrUpdate()
    {
        if (!$this->isSyncEnabled()) {
            return;
        }

        if (!$this->fs->needToSync()) {
            return;
        }

        $jsonFiles = $this->fs->getJsonFiles();

        foreach ($jsonFiles as $jsonFile) {
            $slug = str_replace('.json', '', basename($jsonFile));
            if (!$this->fs->needToSync($slug)) {
                continue;
            }
            $jsonSettings = $this->fs->parseJson($jsonFile);
            $settings = $this->formatSettings($jsonSettings);
            $itemId = $this->getItem($jsonSettings);
            $this->saveRow((int)$itemId, $settings);
        }
    }

    protected function getItem(object $settings)
    {
        $modalClass = 'AmphiBee\\WpgbExtended\\Models\\' . ucfirst(substr($this->type, 0, -1));
        $slug = $settings->{$this->type}[0]->{$this->identifier};
        return call_user_func([$modalClass, 'getBySlug'], $slug);
    }

    /**
     * Save the item in the database
     * @param int $itemId ID of the item
     * @param array $settings Settings of the item
     */
    protected function saveRow(int $itemId, array $settings)
    {
        Database::save_row($this->type, $settings, $itemId);
        $slug = $settings[$this->identifier];
        $this->fs->setDbLastUpdated($this->fs->getLastUpdated(), $slug);
    }

    /**
     * Save item into a json file
     */
    private function export()
    {
        $args = $this->exportArgs();
        $wpgbExport = new Export();
        $settings = $wpgbExport->export_items($args);
        $jsonContent = json_encode((array)$settings, JSON_PRETTY_PRINT);
        $jsonFileName = $settings[$this->type][0]['slug'] ?? sanitize_title($settings[$this->type][0]['name']);
        $this->fs->saveJson($jsonFileName, $jsonContent);
    }

    /**
     * Make settings compatible with the database format
     * @param $settings : Original settings
     * @return array : Formatted settings
     */
    protected function formatSettings($settings): array
    {
        $settings = $settings->{$this->type}[0];
        $settings = (array)$settings;
        if (isset($settings['settings'])) {
            $settings['settings'] = json_encode($settings['settings']);
        }
        if (isset($settings['layout'])) {
            $settings['layout'] = json_encode($settings['layout']);
        }
        unset($settings['id']);
        return $settings;
    }

    /**
     * Set the export argument compatible
     * with the WPGB export items method
     * @return array
     */
    protected function exportArgs(): array
    {
        return [
            'action' => 'wpgb_export',
            'page' => 'wpgb-' . $this->type,
            'type' => $this->type,
            'ids' => $this->itemId,
        ];
    }
}
