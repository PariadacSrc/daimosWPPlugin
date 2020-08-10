<?php namespace Daim\Factories;

use Daim\Factories\factoryView;

/**
*@package Daimos Project Library Wordpress Theme
*/

class metaboxFactory extends factoryView{

	function __construct(){
		$files_dir = dirname(__FILE__).'/src';
		$this->actionHandler($files_dir);
	}

	public function triggerHandler($obj){
		$obj->registerHandlers();
		$obj->renderActions();
	}

}