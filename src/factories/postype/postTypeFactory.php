<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

class postTypeFactory extends factoryView{

	function __construct(){
		//Daimos Main Types
		$files_dir = dirname(__FILE__).'/src';
		$this->actionHandler($files_dir);

		$this->registerExtension(THM_EXTENSION.'factories/postype/');
	}

	public function triggerHandler($obj){
		register_post_type($obj->getPrefix(),$obj->settings());
	}

}