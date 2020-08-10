<?php

/**
*@package Daimos Project Library Wordpress Theme
*/

class Headers extends \Daim\Factories\postTypeView{

	function __construct(){
		$this->setPrefix(DAIM_PRFX.'headers');
	}

	public function settings(){
		return array(
			'capability_type' => 'page',
			'supports'	=> array('thumbnail','title','editor','page-attributes'),
			'public'	=> true,
			'label'		=> __('Headers',DAIM_PLUG_DOMAIN)
		);
	}

	public function handlers(){}

	
}