<?php 

use Daim\Helpers\mainHelper;
/**
*@package Daimos Project Library Wordpress Theme
*/

class sliderGeneric extends \Daim\Factories\shortCodeView{
	
	function __construct(){
		$this->setCodeName(DAIM_PRFX.'slider_generic');
		$this->setTemplates(
			array(
				'default'=>array(
					'vc_value' => __('Generic',DAIM_PLUG_DOMAIN)
				),
				'featured_picture'=>array(
					'vc_value' => __('Featured Picture',DAIM_PLUG_DOMAIN)
				)
			)
		);
	}
	
	public function buildCode($atts,$content=null){
		$atts = shortcode_atts(array(
			/*Post Settings*/
			'post_type' 	=> 'post',
			'cat_list' 		=> '',
			'post_limit' 	=> 9,
			'meta_key' 		=> '',
			/*Link Settings*/
			'include_link' 	=> 1,
			'custom_url_text' => __('Read More',DAIM_PLUG_DOMAIN),
			'custom_url' 	=> 'default',
			'custom_url_link_extrn' => '#',
			/*Template Settings*/
			'order'			=> 'DESC',
			'show_item'		=> '1',
			'main_template'	=> 'default',
			'content' 		=> $content,
			'class_css'  => ''
		),$atts);

		return $this->genericLayoutRender($atts,$this->getDefaultCompDir());
	}
	public function jsComposerMapCode(){
		return array(
			'name'        => __('Main Slider',DAIM_PLUG_DOMAIN),
			'description' => '',
			'category'	  => DAIM_SHORTCODE_REF,
			'base'        => $this->getCodeName(),
			'params'      => array_merge(
				$this->postSettings(),
				$this->linkSettings(),
				$this->templateSettings()
			)
		);
	}

	public function postSettings(){
		return array(
			array(
				'type'       => 'dropdown',
				'heading'    => __('Post Type',DAIM_PLUG_DOMAIN),
				'param_name' => 'post_type',
				'value'      => mainHelper::getAllPostTypesForWPBakery(),
				'std'        => 'post',
				"group" => "<i class='fa fa-cogs'></i> " . __('Content Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __('Category list',DAIM_PLUG_DOMAIN),
				'param_name' => 'cat_list',
				'value'      => '',
				'description'=> __('Use the comma (,) to separate the categories',DAIM_PLUG_DOMAIN),
				"group" => "<i class='fa fa-cogs'></i> " . __('Content Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __('Number of Post',DAIM_PLUG_DOMAIN),
				'param_name' => 'post_limit',
				'value'      => 9,
				"group" => "<i class='fa fa-cogs'></i> " . __('Content Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type' 		 => 'textfield',
				'heading'    => __('Content Meta Key',DAIM_PLUG_DOMAIN),
				'param_name' => 'meta_key',
				'value'      => '',
				'description'=> __('This field indicates the content of the meta key that will be placed just after the title. If this field is empty, its default value is the content of the publication',DAIM_PLUG_DOMAIN),
				"group" => "<i class='fa fa-cogs'></i> " . __('Content Settings' ,DAIM_PLUG_DOMAIN)
			)
		);
	}

	public function linkSettings(){
		return array(
			array(
				'type'       => 'dropdown',
				'heading'    => __('Do you want to include the custom button?',DAIM_PLUG_DOMAIN),
				'param_name' => 'include_link',
				'value'      => array(
					'Yes' => '1',
					'No'  => '0'
				),
				'std'        => 'post',
				"group" => "<i class='fa fa-cogs'></i> " . __('Content Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __('Link Text',DAIM_PLUG_DOMAIN),
				'param_name' => 'custom_url_text',
				'value'      => __('Read More',DAIM_PLUG_DOMAIN),
				'dependency' => array(
					'element' 	=> 'include_link',
                	'value' 	=> '1'
				),
				"group" => "<i class='fa fa-cogs'></i> " . __('Link Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __('Custom Link',DAIM_PLUG_DOMAIN),
				'description'=> __('By default the link points to the detail of the publication, selecting this option can change the link.',DAIM_PLUG_DOMAIN),
				'param_name' => 'custom_url',
				'value'      => array(
					__('Default value',DAIM_PLUG_DOMAIN) => 'default',
					__('Custom Link',DAIM_PLUG_DOMAIN) 	 => 'extrn',
					__('Default value plus a custom link button',DAIM_PLUG_DOMAIN) => 'custom_d_plus_ext',
				),
				'std'        => 'default',
				'dependency' => array(
					'element' 	=> 'include_link',
                	'value' 	=> '1'
				),
				"group" => "<i class='fa fa-cogs'></i> " . __('Link Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __('My Custom Link',DAIM_PLUG_DOMAIN),
				'param_name' => 'custom_url_link_extrn',
				'dependency' => array(
					'element' 	=> 'custom_url',
                	'value' 	=> array('extrn','custom_d_plus_ext')
				),
				'value'      => '#',
				"group" => "<i class='fa fa-cogs'></i> " . __('Link Settings' ,DAIM_PLUG_DOMAIN)
			)
		);
	}

	public function templateSettings(){

		return array(
			array(
				'type'       => 'dropdown',
				'heading'    => __('Order of post',DAIM_PLUG_DOMAIN),
				'param_name' => 'order',
				'value'      => array(
					__('From highest to lowest',DAIM_PLUG_DOMAIN) => 'DESC',
					__('From lowest to highest',DAIM_PLUG_DOMAIN) => 'ASC'
				),
				'std'        => 'DESC',
				"group" => "<i class='fa fa-cogs'></i> " . __('Template Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __('Number of Items displayed',DAIM_PLUG_DOMAIN),
				'param_name' => 'show_item',
				'value'      => array(
					'1',
					'2',
					'3',
					'4',
					'5',
					'6',
					'12'
				),
				'std'        => '1',
				"group" => "<i class='fa fa-cogs'></i> " . __('Template Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type'       => 'dropdown',
				'heading'    => __('Template',DAIM_PLUG_DOMAIN),
				'param_name' => 'main_template',
				'description'=> __('The content of the templates may vary depending on the type of post selected',DAIM_PLUG_DOMAIN),
				'value'      => $this->VCTemplates(),
				'std'        => 'default',
				"group" => "<i class='fa fa-cogs'></i> " . __('Template Settings' ,DAIM_PLUG_DOMAIN)
			)
		);
	}

	//Custom Shortcode Complements
	public static function getCustomUrl($atts,$post){
		switch ($atts['custom_url']) {
			case 'extrn':
				$return = get_permalink($atts['custom_url_link_extrn']);
				break;

			case 'custom_d_plus_ext':
				$return = get_permalink($atts['custom_url_link_extrn']);
				break;
			
			default:
				$return = get_permalink($post->ID);
				break;
		}
		return $return;
	}

	public static function getExtraButton($atts,$post){

		if ($atts['custom_url']==='custom_d_plus_ext') {
			return get_permalink($post->ID);
		}else{
			return false;
		}
	}

}
