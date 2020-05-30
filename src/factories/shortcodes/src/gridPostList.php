<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

class gridPostList extends shortCodeView{
	
	function __construct(){
		$this->setCodeName(DAIM_PRFX.'grid_post_list');
		//Set Custom Filter prepare Query
		$this->setQueryFilter(true);
	}
	
	public function buildCode($atts,$content=null){
		$atts = shortcode_atts(array(
			//
			/*Post Settings*/
			'post_type' 	=> 'post',
			'cat_list' 		=> '',
			'post_limit' 	=> 9,
			'post_per_row' 	=> 3,
			'meta_key' 		=> '',
			/*Link Settings*/
			'include_link' 	=> 1,
			'custom_url_text' => __('Read More',DAIM_PLUG_DOMAIN),
			/*Template Settings*/
			'class_css' 		=> '',
			'id_css' 			=> '',
			'order'			=> 'DESC',
			'main_template'	=> 'default',
			'content' 		=> $content
		),$atts);

		return $this->genericLayoutRender($atts,$this->getDefaultCompDir());

	}

	public function jsComposerMapCode(){
		return array(
			'name'        => __('Grid Post List',DAIM_PLUG_DOMAIN),
			'description' => '',
			'category'	  => DAIM_SHORTCODE_REF,
			'base'        => $this->getCodeName(),
			'params'      => array_merge(
				self::postSettings(),
				self::linkSettings(),
				self::templateSettings()
			)
		);
	}

	public static function postSettings(){
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
				'heading'    => __('Number of Post Limit',DAIM_PLUG_DOMAIN),
				'param_name' => 'post_limit',
				'value'      => 9,
				"group" => "<i class='fa fa-cogs'></i> " . __('Content Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __('Number of Post Per Row',DAIM_PLUG_DOMAIN),
				'param_name' => 'post_per_row',
				'value'      => 3,
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

	public static function linkSettings(){
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
				'type'       => 'textfield',
				'heading'    => __('Custom Link',DAIM_PLUG_DOMAIN),
				'param_name' => 'custom_url_link',
				'value'      => '',
				'dependency' => array(
					'element' 	=> 'include_link',
                	'value' 	=> '1'
				),
				'description'=> __('This field indicates the meta field that contains the publication as a personalized link, if left empty it will use the publication default link',DAIM_PLUG_DOMAIN),
				"group" => "<i class='fa fa-cogs'></i> " . __('Link Settings' ,DAIM_PLUG_DOMAIN)
			)
		);
	}

	public static function templateSettings(){
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
				'heading'    => __('Template',DAIM_PLUG_DOMAIN),
				'param_name' => 'main_template',
				'description'=> __('The content of the templates may vary depending on the type of post selected',DAIM_PLUG_DOMAIN),
				'value'      => array(
					__('Default',DAIM_PLUG_DOMAIN) 	=> 'default',
					__('User',DAIM_PLUG_DOMAIN)   => 'user',
					__('Featured Picture',DAIM_PLUG_DOMAIN)   => 'picture',
				),
				'std'        => 'generic',
				"group" => "<i class='fa fa-cogs'></i> " . __('Template Settings' ,DAIM_PLUG_DOMAIN)
			)
		);
	}

}
