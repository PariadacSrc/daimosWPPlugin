<?php namespace Daim\Helpers;

/**
*@package Daimos Project Library Wordpress Theme
*/

use WP_Query;

class mainHelper{

	public static function filesCalls($dir,$action,$extension='php',...$params){

		if (is_dir($dir) && file_exists($dir)) {

		    if ($dh = opendir($dir)) {

		        while (($file = readdir($dh)) !== false) {

		            if (strrpos($file, ".".$extension) !== FALSE) {

		                self::callMethod($action, $dir, $file,...$params);

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

	public static function countHash(){
		global $daimCountHash;

		$daimCountHash = (isset($daimCountHash))? ($daimCountHash+1):1;
		return $daimCountHash;
	}

	public static function getAllSitePages(){

		$r_query= new WP_Query(array(
			'post_type' => 'page',
		    'orderby'   => 'title',
		    'posts_per_page' => -1,
		    'post_status' => array('publish','private')    
		));
		$return = array();

		foreach ($r_query->posts as $key => $value) {
			$return[$value->ID]=$value->post_title;
		}
		return $return;

	}

	public static function getAllCustomPostType($type='post'){

		$r_query= new WP_Query(array(
			'post_type' => $type,
		    'orderby'   => 'title',
		    'posts_per_page' => -1,    
		));
		$return = array();

		foreach ($r_query->posts as $key => $value) {
			$return[$value->ID]=$value->post_title;
		}
		return $return;

	}

	public static function buildStandarSelect($field,$data,$options,$default=null,$attributes=[]){

		$default = (!isset($default))?[__('Select an option...')]:$default;
		$dkey = array_keys($default)[0];

		ob_start();

			?>
				<select name="<?php echo $field; ?>"
					<?php foreach ($attributes as $attrk => $attrv) { echo $attrk.'="'.$attrv.'" '; } ?>
				>
					<option value="<?php echo $dkey; ?>"><?php echo $default[$dkey]; ?></option>
					<?php foreach ($options as  $key => $value): ?>
						<option value="<?php echo $key ?>" <?php echo ($data==$key)?'selected="select"':''; ?> ><?php echo $value ?></option>
					<?php endforeach; ?>
				</select>
			<?php

		$return = ob_get_contents();
		ob_end_clean();

		return $return;
	}


	public static function getDefaultPicture($list,$key,$basedir='',$defaultBg=''){

		if(isset($list[$key])){
			return ( strlen(trim($list[$key]))>0 )?$basedir.$list[$key]:$defaultBg;
		}

		return $defaultBg;

	}

	public static function getVCTermsList($term,$settings){
		$menus = get_terms( $term, $settings );

		$return = array();

		foreach ($menus as $key => $value) {
			$return[$value->name]=$value->term_id;
		}
		return $return;
	}

}