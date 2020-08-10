<?php namespace Daim\Factories;

use Daim\Factories\factoryView;

/**
*@package Daimos Project Library Wordpress Theme
*/

class shortCodeFactory extends factoryView{

	function __construct(){
		$files_dir = dirname(__FILE__).'/src';
		$this->actionHandler($files_dir);

		$this->registerExtension(THM_EXTENSION.'factories/shortcodes/');
	}

	public function triggerHandler($obj){
		$obj->registerHandlers();
	}

	static public function test(){
		echo "new method";
	}

}