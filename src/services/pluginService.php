<?php namespace Daim\Services;

/**
*@package Daimos Project Library Wordpress Theme
*/

class pluginService{

	public static function register(){
		register_activation_hook( DAIM_PLUGIN_BASE_FILE, array('\\Daim\\Services\\pluginService','activate') );
		register_deactivation_hook(DAIM_PLUGIN_BASE_FILE, array('\\Daim\\Services\\pluginService','deactivate'));
	}

	public static function activate(){
		do_action('on_activate_daimos');
		flush_rewrite_rules(); 
	}
	public static function deactivate(){ 
		do_action('on_deactivate_daimos');
		flush_rewrite_rules(); 
	}

}