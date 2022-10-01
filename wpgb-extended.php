<?php
/*
Plugin Name: 	Gridbuilder ᵂᴾ Extended
Plugin URI:		https://github.com/AmphiBee/wpgb-extended/
Description: 	Gridbuilder ᵂᴾ Extended provides an object oriented API to register templates and (soon) facets. If you register template or facets in your theme, you can safely rely on version control when working with other developers.
Version: 		1.11
Author: 		AmphiBee
Author URI: 	https://amphibee.fr
Text Domain: 	wpgb-extended
License: 		GPLv2 or later
License URI:	http://www.gnu.org/licenses/gpl-2.0.html

Copyright 2021 and beyond | AmphiBee (email : hello@amphibee.fr)

*/

define('WPGB_EXTENDED_DIR', dirname(__FILE__));
define('WPGB_EXTENDED_SRC_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'src');
define('WPGB_EXTENDED_CONFIG_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config');

$autoload = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

if (!file_exists($autoload)) {
    echo 'Autoload not found.';
    exit(1);
}

include $autoload;

new \AmphiBee\WpgbExtended\Bootstrap();
