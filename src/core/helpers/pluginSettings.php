<?php namespace Daim\Core\Helpers;

/**
*@package Daimos Project Library Wordpress Theme
*/

//Libraries
use Daim\Core\Interfaces\customFieldsView;
use Daim\Helpers\mainHelper;

class pluginSettings extends customFieldsView{

	function __construct(){

		$this->setSettings(array(
			array(
				'option_group'=>'daim_plugin_options',
				'option_name'=>'daim_main_header_layout',
				'args'=>''
			),
			array(
				'option_group'=>'daim_plugin_options',
				'option_name'=>'daim_main_footer_layout',
				'args'=>''
			)
		));

		$this->setSections(array(
			array(
				'id'=>'daim_main_options',
				'title'=>__('General Settings'),
				'page'=>'daimos_manager'
			)
		));

		$this->setFields(array(
			array(
				'id'=>'daim_main_header_layout',
				'title'=>'Usar los tipos de publicacion que incluye Daimos por defecto.',
				'callback'=>array($this,'daim_main_header_layout'),
				'page'=>'daimos_manager',
				'section'=>'daim_main_options',
				'args'=>''
			),
			array(
				'id'=>'daim_main_footer_layout',
				'title'=>'Usar los tipos de publicacion que incluye Daimos por defecto.',
				'callback'=>array($this,'daim_main_footer_layout'),
				'page'=>'daimos_manager',
				'section'=>'daim_main_options',
				'args'=>''
			)
		));

	}

	public function daim_main_header_layout(){
		$field = esc_attr(get_option('daim_main_header_layout'));
		$pages = mainHelper::getAllCustomPostType(DAIM_PRFX.'headers');
		echo mainHelper::buildStandarSelect('daim_main_header_layout',$field,$pages,[__('Select a page',DAIM_PLUG_DOMAIN)]);
	}

	public function daim_main_footer_layout(){
		$field = esc_attr(get_option('daim_main_footer_layout'));
		$pages = mainHelper::getAllCustomPostType(DAIM_PRFX.'footers');
		echo mainHelper::buildStandarSelect('daim_main_footer_layout',$field,$pages,[__('Select a page',DAIM_PLUG_DOMAIN)]);
	}
	
}