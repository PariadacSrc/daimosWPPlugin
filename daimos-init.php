<?php global $Daimos;

/**
*@package Daimos Theme Manager
*/

/**
	Plugin Name: Daimos Theme Manager
	Plugin URI: https://www.tecbound.com/plugin
	Description: This will be the main manager for all layouts in tecbound wordpress themes
	Version: 1.00.000
	Author: Pariadac
	Author URI: https://www.tecbound.com/
	License: GPLv2 or later
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin Root File.
if ( ! defined( 'DAIM_PLUGIN_BASE_FILE' ) ) { define( 'DAIM_PLUGIN_BASE_FILE', __FILE__ );}

function microtime_float(){
	list($useg, $seg) = explode(" ", microtime());
	return ((float)$useg + (float)$seg);
}



if(file_exists(dirname(__FILE__).'/vendor/autoload.php')){
	require_once(dirname(__FILE__).'/vendor/autoload.php');
}

\Daim\Services\pluginService::register();
$Daimos = \Daim\DaimosManager::instance();