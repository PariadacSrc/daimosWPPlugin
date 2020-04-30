<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

class includeWidgetsSidebars extends shortCodeView{
	
	function __construct(){
		$this->setCodeName(DAIM_PRFX.'incl_widgets_sidebars');
	}
	
	public function buildCode($atts,$content=null){
		$atts = shortcode_atts(array(
			'widgt_id' 	=> 0
		),$atts);

		return $this->genericLayoutRender($atts,$this->getDefaultCompDir());

	}
	public function jsComposerMapCode(){
		return array(
			'name'        => 'Include Widget Sidebar',
			'description' => '',
			'category'	  => DAIM_SHORTCODE_REF,
			'base'        => $this->getCodeName(),
			'params'      => array(
				array(
					'type'       => 'dropdown',
					'heading'    => __('Select the widget area',DAIM_PLUG_DOMAIN),
					'param_name' => 'widgt_id',
					'value' 	 => $this->getSideBarsList(),
					"group" => "<i class='fa fa-cogs'></i> " . __('General Settings' ,DAIM_PLUG_DOMAIN)
				),
			),
		);
	}

	//Custom Shortcode Complements
	public static function getSideBarsList(){

		$list=[];

		foreach ($GLOBALS['wp_registered_sidebars'] as $key => $item) { $list[$item['name']]= $key; }
		return $list;
	}

	
}
