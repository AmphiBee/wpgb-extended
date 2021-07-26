<?php

namespace AmphiBee\WpgbExtended\Providers;

use WP_Grid_Builder\Admin\Export;
use WP_Grid_Builder\Includes\Database;

/**
 * Facet Sync
 *
 * Sync tool for the Gridbuilder ᵂᴾ Facets
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
class FacetSync
{
    private $facetId = 0;
    protected $type = 'facets';
    protected $fs;

    public function __construct(int $facetId = 0)
    {
        $this->facetId = $facetId;
        $this->fs = new Filemanager($this->type);
    }

    /**
     * Shortcut for the export method
     */
    public function save()
    {
        $this->export();
    }

    /**
     * Maybe import or create facet within the database
     */
    public function importOrUpdate()
    {
        $jsonFiles = $this->fs->getJsonFiles();
        foreach ($jsonFiles as $jsonFile) {
            $facetSettings = $this->fs->parseJson($jsonFile);
            $settings = $this->formatSettings($facetSettings);
            $slug = $facetSettings->facets[0]->slug;
            $facetId = Facet::getBySlug($slug);
            Database::save_row('facets', $settings, $facetId);
        }
    }


    /**
     * Save facet into a json file
     */
    private function export()
    {
        $args = $this->exportArgs();
        $wpgbExport = new Export();
        $facetSettings = $wpgbExport->export_items($args);
        $jsonContent = json_encode((array)$facetSettings, JSON_PRETTY_PRINT);
        $jsonFileName = $facetSettings[$this->type][0]['slug'];
        $this->fs->saveJson($jsonFileName, $jsonContent);
    }

    /**
     * Make settings compatible with the database format
     * @param $settings : Original settings
     * @return array : Formatted settings
     */
    protected function formatSettings($settings): array
    {
        $settings = $settings->facets[0];
        $settings = (array)$settings;
        $settings['settings'] = json_encode($settings['settings']);
        unset($settings['id']);
        return $settings;
    }

    /**
     * Set the export argument compatible
     * with the WPGB export items method
     * @return array
     */
    private function exportArgs(): array
    {
        return [
            'action' => 'wpgb_export',
            'page' => 'wpgb-' . $this->type,
            'type' => $this->type,
            'ids' => $this->facetId,
        ];
    }
}
