<?php

/**
*@package Daimos Project Library Wordpress Theme
*/

class componentsHooks{

	public function register(){

		//Glob Filters
		add_filter('get_daim_header_settings',['componentsHooks','getHeaderSettings'],5,1);

		//New Filters List
		add_action(DAIM_PRFX.'register_prepare_query',['componentsHooks','registerPreQuery'],5,1);

		//Standar Components Actions
		add_action(DAIM_PRFX.'grid_post_content',['componentsHooks','buildCompGridPost'],5,1);

		add_action(DAIM_PRFX.'comp_std_img',['componentsHooks','buildCompStdImg'],5,2);
		add_action(DAIM_PRFX.'comp_button',['componentsHooks','buildCompButton'],5,2);
	}

	//Glob Hooks
	public static function getHeaderSettings($args=[]){return $args;}

	public static function registerPreQuery($obj){

		if($obj->getQueryFilter()){
			$component = $obj->getCodeName();
			add_filter('prepare_'.$component.'_query_args',array('componentsHooks','buildComponentsWPQuery'),1,2);
		}
	}

	public static function buildComponentsWPQuery($args = array(),$atts){

		if(isset($atts)&&is_array($atts)){
			$args = array_merge(
				array(
			        'post_type' => $atts['post_type'],
			        'orderby'   => 'date',
			        'order' 	=> $atts['order'],
			        'posts_per_page' => $atts['post_limit']
			    )
			);

		    $categoryList = explode(',', $atts['cat_list']);

		    if(count($categoryList)>0 && trim(strlen($atts['cat_list']))>0):

		        $taxQuery = array('relation'=>'AND');

		        $taxQuery[]= array(
		            'taxonomy' => 'category',
		            'field'    => 'slug',
		            'terms'    => $categoryList,
		        );

		        $args['tax_query']=$taxQuery;

		    endif;
		}

		return $args;
	}

	public static function buildCompStdImg($link,$args=array()){include (DAIM__DEFAULT_COMP_FOLDER.'blocks/std_img_container.php');}

	public static function buildCompGridPost($obj){include (DAIM__DEFAULT_COMP_FOLDER.'blocks/grid_post_content_'.$obj->comp_template.'.php'); }

	public static function buildCompButton($url,$text=false){include (DAIM__DEFAULT_COMP_FOLDER.'blocks/std_button.php'); }

}