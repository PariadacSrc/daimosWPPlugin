<?php  

/**
*@package Daimos Project Library Wordpress Theme
*/

abstract class shortCodeView{

	private $codeName;
	private $queryFilter;

	public function setCodeName($name){$this->codeName=$name;}
	public function getCodeName(){return $this->codeName;}

	public function setQueryFilter($val=false){$this->queryFilter=$val;}
	public function getQueryFilter(){return $this->queryFilter;}

	public function getDefaultCompDir(){
		return DAIM__DEFAULT_COMP_FOLDER.$this->getCodeName().'.php';
	}

	public function genericLayoutRender($atts=array(),$layout='',$content=''){
		ob_start();


			include( $layout );

		$return = ob_get_contents();
		ob_end_clean();

		return $return;
	}

	public function registerHandlers(){

		add_shortcode( $this->codeName, array($this,'buildCode'));
		//Register Pre Query Builder
		do_action(DAIM_PRFX.'register_prepare_query',$this);

		//WP Bakery Register ShortCode Map
		if ( function_exists( 'vc_lean_map' ) ) {
			if(is_array($this->jsComposerMapCode())){
				vc_lean_map( $this->codeName, array($this,'generalVCFields') );
			}
		}
	}

	public function generalVCFields(){
		$settings = [
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

		$glob = $this->jsComposerMapCode();

		if (isset($glob['params'])){ $glob['params'] = array_merge($glob['params'],$settings);}
		if(!isset($glob['icon'])){$glob['icon']='daim-vc-logo';}

		return $glob;

	}
	
	abstract public function buildCode($atts,$content=null);
	abstract public function jsComposerMapCode();

}