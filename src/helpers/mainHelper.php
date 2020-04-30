<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

class mainHelper{

	public static function filesCalls($dir,$action){

		if (is_dir($dir) && file_exists($dir)) {

		    if ($dh = opendir($dir)) {

		        while (($file = readdir($dh)) !== false) {

		            if (strrpos($file, ".php") !== FALSE) {

		                self::callMethod($action, $dir, $file);

		            }
		        }

		        closedir($dh);
		    }
		}
	}
	public static function callMethod($action,...$params){

		if(is_array($action)){

			$class = $action[0];
			$method = $action[1];

			if(is_object($class)): 
				$class->$method(...$params);
			else: 
				$class::$method(...$params);
			endif;

		}elseif(is_callable($action)){
			$action(...$params);
		}
	}


	public static function getCustomDate($atts,$post){

		switch ($atts['post_type']) {
			case 'tp_event':

				$startDate = get_post_meta($post->ID,'tp_event_date_start');
				$endDate = get_post_meta($post->ID,'tp_event_date_end');


				if(is_array($startDate)){
					$return[__('Start Date',DAIM_PLUG_DOMAIN)] = date_i18n('F d, Y',strtotime($startDate[0]));
				}else{
					$return[__('Start Date',DAIM_PLUG_DOMAIN)] = date_i18n('F d, Y',strtotime($post->post_date_gmt));
				}
				if(is_array($endDate)){
					$return[__('End Date',DAIM_PLUG_DOMAIN)] = date_i18n('F d, Y',strtotime($endDate[0]));
				}

				break;
			
			default:
				$return = array(
					__('Date',DAIM_PLUG_DOMAIN) => date_i18n('F d, Y',strtotime($post->post_date_gmt))
				);
				break;
		}

		return $return;
	}
	public static function getAllPostTypesForWPBakery(){

		$types = get_post_types(
			array(
				'public'   => true
	   		),'objects',
			'and'
		);
		$return = array();

		foreach ($types as $key => $value) {
			$return[$value->label]=$key;
		}
		return $return;
	}
	public static function getAllPostByTypeForWPBakery($type='page'){

		$r_query= new WP_Query(array(
			'post_type' => $type,
		    'orderby'   => 'date',
		    'posts_per_page' => -1,    
		));
		$return = array();

		foreach ($r_query->posts as $key => $value) {
			$return[$value->post_title]=$value->ID;
		}
		return $return;
	}

	public static function setMapOption($obj){
		return [
			'val' => $obj->ID,
			'text' => $obj->post_name
		];
	}


	public static function getRenderVCStyles($id){

		$styles = get_post_meta($id, '_wpb_shortcodes_custom_css', true);

		if (!empty($styles)){
			$styles = strip_tags($styles);
			echo '<style type="text/css" data-type="vc_shortcodes-custom-css">'.$styles.'</style>';
		}

	}

}