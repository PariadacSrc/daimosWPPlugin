<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

class pluginService{

	function __construct(){}

	public function register(){

		register_activation_hook( DAIM_PLUGIN_FILE, array($this,'activate') );
		register_deactivation_hook(DAIM_PLUGIN_FILE, array($this,'deactivate'));

	}

	public function activate(){ flush_rewrite_rules(); }
	public function deactivate(){ flush_rewrite_rules(); }

}