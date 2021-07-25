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

    public function __construct(int $facetId = 0)
    {
        $this->facetId = $facetId;
        Filemanager::maybeCreateJsonFolder('facet');
    }

    public function save()
    {
        $this->export();
    }

    public function importOrUpdate() {
        $path = Filemanager::getJsonFolder() . DIRECTORY_SEPARATOR . 'facet';
        $jsonFiles = Filemanager::getJsonFiles($path);
        foreach ($jsonFiles as $jsonFile) {
            $facetSettings = Filemanager::parseJson($jsonFile);
            $settings = $this->formatSettings($facetSettings);
            $slug = $facetSettings->facets[0]->slug;
            $facetId = Facet::getBySlug($slug);

            Database::save_row('facets', $settings, $facetId);

        }
    }

    protected function formatSettings($settings) {
        $settings = $settings->facets[0];
        $settings = (array) $settings;
        $settings['settings'] = json_encode($settings['settings']);
        unset($settings['id']);
        return $settings;
    }

    private function export() {
        $args = $this->exportArgs();
        $wpgbExport = new Export();
        $facetSettings = $wpgbExport->export_items($args);
        $jsonContent = wp_json_encode( (array) $facetSettings );
        $jsonFileName = $facetSettings['facets'][0]['slug'];
        Filemanager::saveJson($jsonFileName, 'facet', $jsonContent);
    }

    private function exportArgs() {
        return [
            'action' => 'wpgb_export',
            'page' => 'wpgb-facets',
            'type' => 'facets',
            'ids' => $this->facetId,
        ];
    }
}
