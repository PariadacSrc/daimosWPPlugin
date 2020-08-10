<?php  namespace Daim\Factories;

/**
*@package Daimos Project Library Wordpress Theme
*/

abstract class shortCodeView{

	private $codeName;
	private $templates;

	public function setCodeName($name){$this->codeName=$name;}
	public function getCodeName(){return $this->codeName;}

	public function setTemplates($template){$this->templates=$template;}
	public function getTemplates(){return $this->templates;}

	public function generalSettings(){
		return [
			array(
				'type'       => 'textfield',
				'heading'    => __('Custom CSS Class',DAIM_PLUG_DOMAIN),
				'param_name' => 'class_css',
				'value'      => '',
				"group" => "<i class='fa fa-cogs'></i> " . __('Template Settings' ,DAIM_PLUG_DOMAIN)
			),
			array(
				'type'       => 'textfield',
				'heading'    => __('Custom CSS ID',DAIM_PLUG_DOMAIN),
				'param_name' => 'id_css',
				'value'      => '',
				"group" => "<i class='fa fa-cogs'></i> " . __('Template Settings' ,DAIM_PLUG_DOMAIN)
			)
		];
	}

	/*
	* Builder Main Methods
	*/
	public function getDefaultCompDir(){return DAIM__DEFAULT_COMP_FOLDER.$this->getCodeName().'.php';}
	public function genericLayoutRender($atts=array(),$layout='',$content=''){

		$atts = shortcode_atts( array_merge($this->purgeSCAttributes(),['content'=>$content]),$atts );

		ob_start();
			include( $layout );
		$return = ob_get_contents();
		ob_end_clean();

		return $return;
	}

	//Get default values from shortcode
	public function purgeSCAttributes(){

		$params = array_merge($this->jsComposerMapCode()['params'],$this->generalSettings());
		$purgeParams = array();

		foreach ($params as $item) {

			if(isset($item['std'])){
				$purgeParams[$item['param_name']]=$item['std'];
			}elseif(isset($item['value'])){
				$purgeParams[$item['param_name']]=$item['value'];
			}else{
				$purgeParams[$item['param_name']]='';
			}
			
		}

		return $purgeParams;
	}

	public function registerHandlers(){

		add_shortcode( $this->codeName, array($this,'buildCode'));
		$this->attachHooks();
		//VC Register ShortCode Map
		if ( function_exists( 'vc_lean_map' ) ) {
			if(is_array($this->jsComposerMapCode())){
				vc_lean_map( $this->codeName, array($this,'generalVCFields') );
			}
		}
	}

	public function generalVCFields(){
		
		$glob = $this->jsComposerMapCode();

		if (isset($glob['params'])){ $glob['params'] = array_merge($glob['params'],$this->generalSettings());}
		if(!isset($glob['icon'])){$glob['icon']='daim-vc-logo';}

		return $glob;
	}

	/*
	* Component Hooks
	*/
	private function attachHooks(){
		add_filter('prepare_'.$this->getCodeName().'_query_args',array($this,'buildComponentWPQuery'),1,2);
		add_filter('sc_templates_'.$this->getCodeName(),array($this,'getTemplates'),1);
	}
	public function buildComponentWPQuery($args = array(),$atts){

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

	/*
	* Component Templates
	*/
	public function VCTemplates(){

		$devTemplates = apply_filters('sc_templates_'.$this->getCodeName(),[]);

		if(is_array($devTemplates)){
			foreach ($devTemplates as $tempkey => $temp) {
				if(isset($temp['vc_value'])){
					$templates[$temp['vc_value']]=$tempkey;
				}
			}
		}

		return $templates;
	}
	
	abstract public function buildCode($atts,$content=null);
	abstract public function jsComposerMapCode();

}