<?php namespace Daim\Services;

/**
*@package Daimos Project Library Wordpress Theme
*/

use Daim\Helpers\mainHelper;

class libsService{

	public function register(){
		
		$dir = DAIM_PLUGIN_DIR . 'libs/';
		//Main Daimos extension libraries location
		$libsClasses = [
			//'socialRegister'=>$dir.'social_register/socialRegister.php'
		];

		foreach ($libsClasses as $class => $route) {
			require_once($route);
			(new $class())->register();
		}
	}

}