<?php namespace Daim\Services;

/**
*@package Daimos Project Library Wordpress Theme
*/

use Daim\Core\Helpers\pluginSettings;
use Daim\Core\Classes\classUserHandler;

class settingsService{

	public function register(){
		//Main Settings

		add_action('admin_menu',function(){
			(new pluginSettings())->registerCustomFileds();
		});

	}

}