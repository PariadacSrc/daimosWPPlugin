<?php

/**
*@package Daimos Project Library Wordpress Theme
*/

class Footers extends \Daim\Factories\postTypeView{

	function __construct(){
		$this->setPrefix(DAIM_PRFX.'footers');
	}

	public function settings(){
		return array(
			'capability_type' => 'page',
			'supports'	=> array('thumbnail','title','editor','page-attributes'),
			'public'	=> true,
			'label'		=> __('Footers',DAIM_PLUG_DOMAIN)
		);
	}

	public function handlers(){}

}