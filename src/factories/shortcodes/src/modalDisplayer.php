<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

class modalDisplayer extends \Daim\Factories\shortCodeView{
	
	function __construct(){
		$this->setCodeName(DAIM_PRFX.'modal_displayer');
		$this->setTemplates(
			array(
				'default'=>array(
					'vc_value' => __('Default',DAIM_PLUG_DOMAIN)
				)
			)
		);

	}
	
	public function buildCode($atts,$content=null){

		return $this->genericLayoutRender($atts,$this->getDefaultCompDir());
	}

	public function jsComposerMapCode(){
		return array(
			'name'        => __('Modal Displayer',DAIM_PLUG_DOMAIN),
			'description' => '',
			'category'	  => DAIM_SHORTCODE_REF,
			'base'        => $this->getCodeName(),
			'params'      => array_merge(
				$this->templateSettings()
			)
		);
	}


	public function templateSettings(){
		return array(
			array(
				'type'       => 'dropdown',
				'heading'    => __('Template',DAIM_PLUG_DOMAIN),
				'param_name' => 'main_template',
				'description'=> __('The content of the templates may vary depending on the type of post selected',DAIM_PLUG_DOMAIN),
				'value'      => $this->VCTemplates(),
				'std'        => 'generic',
				"group" => "<i class='fa fa-cogs'></i> " . __('Template Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __('Button Text',DAIM_PLUG_DOMAIN),
				'param_name' => 'custom_url_text',
				'value'      => __('Read More',DAIM_PLUG_DOMAIN),
				"group" => "<i class='fa fa-cogs'></i> " . __('Template Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type'       => 'textarea_html',
				'heading'    => __('Content',DAIM_PLUG_DOMAIN),
				'param_name' => 'content',
				'value'      => __('Read More',DAIM_PLUG_DOMAIN),
				"group" => "<i class='fa fa-cogs'></i> " . __('Template Settings' ,DAIM_PLUG_DOMAIN)
			),

		);
	}

}