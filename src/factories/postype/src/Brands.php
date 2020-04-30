<?php

/**
*@package Daimos Project Library Wordpress Theme
*/

class Brands extends postTypeView{

	function __construct(){
		$this->setPrefix(DAIM_PRFX.'brands');
	}

	public function settings(){
		return array(
			'capability_type' => 'page',
			'supports'	=> array('thumbnail','title','editor','page-attributes'),
			'public'	=> true,
			'label'		=> __('Brands',DAIM_PLUG_DOMAIN)
		);
	}

	public function handlers(){}
}