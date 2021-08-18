<?php

namespace AmphiBee\WpgbExtended\Providers;

/**
 * Filemanager
 *
 * Information about files
 *
 * @link    https://github.com/AmphiBee/wpgb-extended/
 * @author  amphibee
 * @link    https://amphibee.fr
 * @version 1.0
 * @license https://opensource.org/licenses/mit-license.html MIT License
 */
class Filemanager
{
    protected $type;
    protected $lastUpdatedFile;
    protected $lastUpdated;

    public function __construct(string $type)
    {
        $this->setType($type);
        $this->maybeCreateJsonFolder();
    }

    /**
     * Get the type of item
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the type of item
     * @param mixed $type
     * @return Filemanager
     */
    public function setType($type): Filemanager
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get last updated datas from generated file
     * @return array
     */
    public function getLastUpdatedDatas(): array
    {
        $default = ['_wpgb_last_sync' => 0];

        $lastUpdatedFile = $this->getLastUpdatedFile();

        if (!file_exists($lastUpdatedFile)) {
            return $default;
        }

        $this->lastUpdated = include $lastUpdatedFile;

        if (!is_array($this->lastUpdated)) {
            return $default;
        }

        if (!isset($this->lastUpdated['_wpgb_last_sync'])) {
            $this->lastUpdated['_wpgb_last_sync'] = 0;
        }

        return $this->lastUpdated;
    }

    /**
     * Get the last updated time
     * @return int
     */
    public function getLastUpdated($itemSlug = '_wpgb_last_sync'): int
    {
        if (!is_null($this->lastUpdated) && isset($this->lastUpdated[$itemSlug])) {
            return $this->lastUpdated[$itemSlug];
        }

        $this->lastUpdated = $this->getLastUpdatedDatas();

        return (int)$this->lastUpdated[$itemSlug];
    }

    /**
     * Set the last update time
     * @param int $lastUpdated
     * @return Filemanager
     */
    public function setLastUpdated(int $lastUpdated, string $label = '_wpgb_last_sync'): Filemanager
    {
        $params = $this->getLastUpdatedDatas();

        $path = $this->getLastUpdatedFile();

        $params[$label] = $lastUpdated;
        if ($label !== '_wpgb_last_sync') {
            $params['_wpgb_last_sync'] = $lastUpdated;
        }

        $params = $this->cleanLastSyncParams($params);

        $phpFileContent = '<?php return ' . var_export($params, true) . ';';
        file_put_contents($path, $phpFileContent);
        $this->setDbLastUpdated($lastUpdated, $label);
        $this->lastUpdated = $lastUpdated;
        return $this;
    }

    public function getDbLastSync(): array
    {
        return (array)get_option("wpgb/{$this->type}/last_sync");
    }

    /**
     * Get the last updated time from database
     * @return int
     */
    public function getDbLastUpdated($itemSlug = '_wpgb_last_sync'): int
    {
        $lastUpdated = $this->getDbLastSync();

        if (!isset($lastUpdated[$itemSlug])) {
            $lastUpdated[$itemSlug] = 0;
        }

        return (int)$lastUpdated[$itemSlug];
    }

    /**
     * Get the last updated time from database
     * @return bool
     */
    public function setDbLastUpdated($lastUpdated, string $label = '_wpgb_last_sync'): bool
    {
        $lastSync = $this->getDbLastSync();
        $lastSync[$label] = $lastUpdated;

        if ($label !== '_wpgb_last_sync') {
            $lastSync['_wpgb_last_sync'] = $lastUpdated;
        }

        $lastSync = $this->cleanLastSyncParams($lastSync);

        return update_option("wpgb/{$this->type}/last_sync", $lastSync, true);
    }

    public function cleanLastSyncParams(array $params): array {
        $allowed = [ '_wpgb_last_sync' ];

        foreach ($this->getJsonFiles() as $jsonFile) {
            $allowed[] = str_replace('.json', '', basename($jsonFile));
        }

        return array_intersect_key($params, array_flip($allowed));
    }

    /**
     * Get the last updated time
     * @return int
     */
    public function getLastUpdatedFile(): string
    {
        $path = $this->getJsonTypeFolder();
        $this->lastUpdatedFile = $path . DIRECTORY_SEPARATOR . 'last-updated.php';
        return $this->lastUpdatedFile;
    }

    /**
     * Set the last updated file
     * @param string $lastUpdatedFile
     * @return Filemanager
     */
    public function setLastUpdatedFile(string $lastUpdatedFile): Filemanager
    {
        $this->lastUpdatedFile = $lastUpdatedFile;
        return $this;
    }


    /**
     * Indicate if synchronisation is needed
     * @return bool
     */
    public function needToSync(string $slug = '_wpgb_last_sync'): bool
    {
        $lastUpdated = $this->getLastUpdated($slug);
        $dbLastUpdated = $this->getDbLastUpdated($slug);

        return $dbLastUpdated !== $lastUpdated;
    }

    /**
     * Create json folders if needed
     */
    public function maybeCreateJsonFolder()
    {
        $path = $this->getJsonFolder();

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        if (!file_exists($path . DIRECTORY_SEPARATOR . $this->type)) {
            mkdir($path . DIRECTORY_SEPARATOR . $this->type, 0777, true);
        }
    }

    /**
     * Return the main json folder
     * @return string
     */
    protected static function getJsonFolder(): string
    {
        return apply_filters('wp_grid_builder/facet/json_folder', get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'wpgb-json');
    }

    /**
     * Return the specific type json folder
     * @return string
     */
    protected function getJsonTypeFolder(): string
    {
        $path = self::getJsonFolder();
        return $path . DIRECTORY_SEPARATOR . $this->type;
    }

    /**
     * Save settings as json and
     * set the last updated time
     * @param string $name : Json slug
     * @param string $content : The settings of the item
     */
    public function saveJson(string $name, string $content)
    {
        $path = $this->getJsonTypeFolder();
        file_put_contents($path . DIRECTORY_SEPARATOR . $name . '.json', $content);
        $this->setLastUpdated(time(), $name);
    }

    /**
     * Read a json file
     * @param string $file
     * @return mixed
     */
    public function parseJson(string $file)
    {
        $content = file_get_contents($file);
        return \json_decode($content);
    }

    /**
     * Collect every json file of a type folder
     * @return array
     */
    public function getJsonFiles(): array
    {
        $path = $this->getJsonTypeFolder();
        $jsonFiles = [];
        $files = scandir($path);
        foreach ($files as $file) {
            if (strpos($file, '.json') === false) {
                continue;
            }
            $jsonFiles[] = $path . DIRECTORY_SEPARATOR . $file;
        }
        return $jsonFiles;
    }
}
