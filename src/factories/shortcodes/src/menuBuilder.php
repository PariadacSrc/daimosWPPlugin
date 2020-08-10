<?php 

use Daim\Helpers\mainHelper;
/**
*@package Daimos Project Library Wordpress Theme
*/

class menuBuilder extends \Daim\Factories\shortCodeView{
	
	function __construct(){
		$this->setCodeName(DAIM_PRFX.'menu_builder');
	}
	
	public function buildCode($atts,$content=null){
		$atts = shortcode_atts(array(

			'menu_id' 	=> 0,
			'back_color'=> 'rgba(0,0,0,0)',
			'template' 	=> 'default'
		),$atts);

		return $this->genericLayoutRender($atts,DAIM__DEFAULT_COMP_FOLDER.'daim_menu_builder.php');

	}
	public function jsComposerMapCode(){
		return array(
			'name'        => __('Menu Builder',DAIM_PLUG_DOMAIN),
			'description' => '',
			'category'	  => DAIM_SHORTCODE_REF,
			'base'        => DAIM_PRFX.'menu_builder',
			'params'      => array(
				//Content Settings
				array(
					'type'       => 'dropdown',
					'heading'    => __('Select Menu',DAIM_PLUG_DOMAIN),
					'param_name' => 'menu_id',
					'value'      => array_merge( array('Default' =>'0' ),mainHelper::getVCTermsList('nav_menu', array( 'hide_empty' => true )) ),
					'std'        => '0',
					"group" => "<i class='fas fa-cogs'></i> " . __('Main Settings' ,DAIM_PLUG_DOMAIN)
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => __('Background Color',DAIM_PLUG_DOMAIN),
					'param_name' => 'back_color',
					'std'        => 'rgba(0,0,0,0)',
					"group" => "<i class='fas fa-cogs'></i> " . __('Main Settings' ,DAIM_PLUG_DOMAIN)
				),
				array(
					'type'       => 'dropdown',
					'heading'    => __('Template',DAIM_PLUG_DOMAIN),
					'param_name' => 'template',
					'value'      => array(
						'default' => 'Default'
					),
					'std'        => 'default',
					"group" => "<i class='fas fa-cogs'></i> " . __('Main Settings' ,DAIM_PLUG_DOMAIN)
				),
				
			),
		);
	}

	//Custom Shortcode Complements
	
}
