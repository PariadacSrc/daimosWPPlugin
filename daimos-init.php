<?php global $daimosMainTheme;

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

if(file_exists(dirname(__FILE__).'/autoload/packageAutoload.php')){
	require_once(dirname(__FILE__).'/autoload/packageAutoload.php');
}

add_action( 'init', function(){
	packageAutoload::instance();
	$daimosMainTheme = DaimosManager::instance();
}, 0 );

