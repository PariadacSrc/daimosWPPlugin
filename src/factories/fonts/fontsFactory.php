<?php namespace Daim\Factories;

use Daim\Factories\factoryView;

/**
*@package Daimos Project Library Wordpress Theme
*/

class fontsFactory extends factoryView{

	function __construct(){
		//Daimos Main Types
		$files_dir = dirname(__FILE__).'/src';
		$this->actionHandler($files_dir);
		
		$this->registerExtension(THM_EXTENSION.'factories/fonts/');
	}

	public function triggerHandler($obj){
		$obj->registerHandlers();
	}

}