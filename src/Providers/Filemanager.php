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
     * Get the last updated time
     * @return int
     */
    public function getLastUpdated(): int
    {
        if (!is_null($this->lastUpdated)) {
            return $this->lastUpdated;
        }

        $lastUpdatedFile = $this->getLastUpdatedFile();

        if (!file_exists($lastUpdatedFile)) {
            return false;
        }

        $lastUpdated = include $lastUpdatedFile;
        $this->setLastUpdated($lastUpdated);

        return (int) $this->lastUpdated;
    }

    /**
     * Set the last update time
     * @param int $lastUpdated
     * @return Filemanager
     */
    public function setLastUpdated(int $lastUpdated): Filemanager
    {
        $path = $this->getLastUpdatedFile();
        $phpFileContent = '<?php return ' . $lastUpdated . '; ?>';
        file_put_contents($path, $phpFileContent);
        update_option("wpgb/{$this->type}/last_sync", $lastUpdated);
        $this->lastUpdated = $lastUpdated;
        return $this;
    }

    /**
     * Get the last updated time
     * @return int
     */
    public function getLastUpdatedFile(): int
    {
        $path = $this->getJsonTypeFolder();
        $this->lastUpdatedFile = $path . DIRECTORY_SEPARATOR . 'last-updated.php';
        return (int) $this->lastUpdatedFile;
    }

    /**
     * Set the last updated file
     * @param string $lastUpdatedFile
     * @return Filemanager
     */
    public function setLastUpdatedFile(string $lastUpdatedFile)
    {
        $this->lastUpdatedFile = $lastUpdatedFile;
        return $this;
    }


    /**
     * Indicate if synchronisation is needed
     * @return bool
     */
    public function needToSync(): bool
    {
        $lastUpdated = $this->getLastUpdated();
        return (int) get_option("wpgb/{$this->type}/last_sync") !== $lastUpdated;
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
        $this->setLastUpdated(time());
    }

    /**
     * Read a json file
     * @param string $file
     * @return mixed
     */
    public function parseJson(string $file)
    {
        $content = file_get_contents($file);
        return json_decode($content);
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
