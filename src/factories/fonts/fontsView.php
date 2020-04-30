<?php  

/**
*@package Daimos Project Library Wordpress Theme
*/

abstract class fontsView{

	private $settings;

	public function setSettings($settings){
		if(is_array($settings)){
			$this->settings=$settings;
		}
	}
	public function getSettings(){ return $this->settings;}

	/*
	* Main Handler
	*/
	public function registerHandlers(){
		add_filter('vc_after_init', array($this,'fontHandler'));
	}

	public function fontHandler(){
		add_filter('vc_google_fonts_get_fonts_filter', array($this,'setFonts'));
	}

	public function setFonts($fonts_list){

		foreach ($this->getSettings() as $font) {
			$fonts_list[] = (object) $font;
		}
		return $fonts_list;
	}
	
}