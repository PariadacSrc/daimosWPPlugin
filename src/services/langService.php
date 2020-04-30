<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

class langService{

	function __construct(){}

	public function register(){
		add_action( 'after_setup_theme', array($this,'mainThemeTextDomain') );
	}

	//Extra Settings
	/**
	* Set Theme Text Domain
	*/
	public function mainThemeTextDomain(){
		load_theme_textdomain( DAIM_PLUG_DOMAIN, DAIM_THEME_DIR . '/lang' );
	}

}