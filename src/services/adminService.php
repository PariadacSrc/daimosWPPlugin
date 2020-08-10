<?php namespace Daim\Services;

/**
*@package Daimos Project Library Wordpress Theme
*/

class adminService{

	function __construct(){}

	public function register(){

		add_action('admin_menu', function(){
			add_menu_page(
				'Daimos Theme Manager',
				'Daimos Manager',
				'manage_options',
				'daimos_manager',
				array($this,'mainIndex'),
				DAIM_PLUGIN_URL.'assets/img/admin/logo.png',
				5
			);
		});

		
	}

	public function mainIndex(){
		include DAIM_PLUGIN_DIR.'/templates/admin/dashboard.php';
	}

}