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

    public static function needToSync($type)
    {
        $path = self::getJsonFolder();
        $lastUpdatedFile = $path . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . 'last-updated.php';
        if (!file_exists($lastUpdatedFile)) {
            return false;
        }
        include $lastUpdatedFile;
        return get_option("wpgb/{$type}/last_sync") !== $wpgbFacetsHash;
    }

    public static function maybeCreateJsonFolder($type)
    {
        $path = self::getJsonFolder();
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        if (!file_exists($path . DIRECTORY_SEPARATOR . $type)) {
            mkdir($path . DIRECTORY_SEPARATOR . $type, 0777, true);
        }
    }

    public static function getJsonFolder()
    {
        return apply_filters('wp_grid_builder/facet/json_folder', get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'wpgb-json');
    }

    public static function saveJson($name, $type, $content) {
        $path = self::getJsonFolder();
        file_put_contents($path . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $name . '.json', $content);
        self::setLastExportTime('facet', $path);
    }

    public static function setLastExportTime($type, $path)
    {
        $hash = self::getJsonFolderHash($path . DIRECTORY_SEPARATOR . $type);
        $phpFileContent = '<?php $wpgbFacetsHash = \'' . $hash . '\'; ?>';
        file_put_contents($path . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . 'last-updated.php', $phpFileContent);
        update_option("wpgb/{$type}/last_sync", $hash);
    }

    public static function parseJson($file) {
        $content = file_get_contents($file);
        return json_decode($content);
    }

    public static function getJsonFiles($dir): array
    {
        $jsonFiles = [];
        $files = scandir($dir);
        foreach ($files as $file) {
            if (strpos($file, '.json') === false) {
                continue;
            }
            $jsonFiles[] = $dir . DIRECTORY_SEPARATOR . $file;
        }
        return $jsonFiles;
    }

    public static function getJsonFolderHash($dir)
    {
        $files = self::getJsonFiles($dir);
        $hashes = [];
        foreach ($files as $file) {
            $hashes[] = md5_file($file);
        }
        return md5(json_encode($hashes));
    }
}
