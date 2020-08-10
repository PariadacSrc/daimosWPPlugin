<?php namespace Daim\Hooks;

/**
*@package Daimos Project Library Wordpress Theme
*/

class componentsHooks{

	public function register(){

		//Glob Filters
		add_filter('get_daim_header_settings',['Daim\Hooks\componentsHooks','getHeaderSettings'],5,1);
		add_filter('d_login_menu_options',['Daim\Hooks\componentsHooks','buildLoginMenu'],5,1);

		//Standar Components Actions
		add_action(DAIM_PRFX.'internal_template',['Daim\Hooks\componentsHooks','buildCompInternalBlock'],5,2);

		add_action(DAIM_PRFX.'comp_std_img',['Daim\Hooks\componentsHooks','buildCompStdImg'],5,2);
		add_action(DAIM_PRFX.'comp_button',['Daim\Hooks\componentsHooks','buildCompButton'],5,2);

		//Global Plugin Actions
		add_action(DAIM_PRFX.'render_main_block',['Daim\Hooks\componentsHooks','renderGlobHeader'],5,1);
	}

	//Glob Hooks
	public static function getHeaderSettings($args=[]){return $args;}

	public static function buildCompStdImg($link,$args=array()){include (DAIM__DEFAULT_COMP_FOLDER.'blocks/std_img_container.php');}

	public static function buildCompInternalBlock($obj){

		$compName = $obj->comp_prefix.'_'.$obj->comp_template.'.php';

		if(file_exists(THM_EXTENSION.'components/'.$compName)){
			include(THM_EXTENSION.'components/'.$compName);

		}elseif(file_exists(DAIM__DEFAULT_COMP_FOLDER.'blocks/'.$compName)){
			include(DAIM__DEFAULT_COMP_FOLDER.'blocks/'.$compName);
		}

	}

	public static function buildCompButton($url,$text=false){include (DAIM__DEFAULT_COMP_FOLDER.'blocks/std_button.php'); }
	public static function buildLoginMenu($options){return $options;}


	public static function renderGlobHeader($block){
		global $post;
		$metaBlock = DAIM_PRFX.'post_'.$block;

		if(count(get_post_meta($post->ID,$metaBlock))>0){
			do_action($metaBlock,$post->ID);

		}else{
			$blockVal = get_option('daim_main_'.$block.'_layout');

			$args = ['p'=>intval($blockVal),'post_type'=>DAIM_PRFX.$block.'s'];
			$query = new \WP_Query( $args );

			if ( $query->have_posts() ) {
                    
                while ( $query->have_posts() ) {
                	$query->the_post();
                    $post = get_post();

                	\Daim\Helpers\mainHelper::getRenderVCStyles($post->ID);
					echo do_shortcode($post->post_content);

                }
                
                wp_reset_postdata();
                $post = get_post();
            }
		}

	}	
}