<?php

namespace AmphiBee\WpgbExtended\Facades;

/**
 * Class Config : Config loader
 * @package AmphiBee
 */
class Config
{

    private static $config;

    /**
     * Initialize class.
     *
     * @return void
     * @since 3.3.0
     *
     */
    public static function loadConfig()
    {
        self::$config = require(WPGB_EXTENDED_CONFIG_DIR . DIRECTORY_SEPARATOR . 'setup.php');
    }

    public static function get($domain)
    {
        $config = self::getAll();
        return $config[$domain] ?? [];
    }

    public static function getAll()
    {
        if (is_null(self::$config)) {
            self::loadConfig();
        }
        return self::$config;
    }
}
