<?php  

/**
*@package Daimos Project Library Wordpress Theme
*/

abstract class iconsView{

	private $iconLib;
	private $iconList;
	private $iconHeader;
	private $resourceDir;
	private $version;

	public function setIconLib($name){$this->iconLib=$name;}
	public function getIconLib(){return $this->iconLib;}

	public function setIconList($name){$this->iconList=$name;}
	public function getIconList(){return $this->iconList;}

	public function setIconHeader($name){$this->iconHeader=$name;}
	public function getIconHeader(){return $this->iconHeader;}

	public function setResourceDir($dir){$this->resourceDir=$dir;}
	public function getResourceDir(){return $this->resourceDir;}

	public function setVersion($ver){$this->version=$ver;}
	public function getVersion(){return $this->version;}


	public function registerHandlers(){

		//WP Bakery Register ShortCode Map
		if ( function_exists( 'vc_map' ) ) {

			add_filter( 'init', array($this,'registerFontBox'), 40 );
			add_filter( 'vc_after_init',array($this,'registerFont'), 40 );
			add_filter( 'vc_iconpicker-type-'.$this->getIconLib(), array($this,'getIconList'));

			/**
			 * Register Backend and Frontend CSS Styles
			 */
			add_action( 'vc_base_register_front_css', array($this,'registerCSS') );
			add_action( 'vc_base_register_admin_css', array($this,'registerCSS') );
			add_action( 'admin_enqueue_scripts', array($this,'registerCSS') );
			/**
			 * Enqueue Backend and Frontend CSS Styles
			 */
			add_action( 'vc_backend_editor_enqueue_js_css', array($this,'enqueuStyles') );
			add_action( 'vc_frontend_editor_enqueue_js_css',array($this,'enqueuStyles') );
			/**
			 * Enqueue CSS in Frontend when it's used
			 */
			add_action('vc_enqueue_font_icon_element', array($this,'callFont'));
		}
	}

	/**
	 * Add font picker setting to icon box module when you select your font family from the dropdown
	 */

	public function registerFontBox(){
		$param = WPBMap::getParam( 'vc_icon', 'type' );
		
		$param['value'][$this->getIconHeader()] = $this->getIconLib();
		vc_update_shortcode_param( 'vc_icon', $param );
	}

	public function registerFont(){
		$settings = array(
			'type' => 'iconpicker',
			'heading' => $this->getIconHeader(),
			'param_name' => 'icon_'.$this->getIconLib(),
			'settings' => array(
				'emptyIcon' => false,
				'type' => $this->getIconLib()
			),
			'dependency' => array(
				'element' => 'type',
				'value' => $this->getIconLib(),
			),
			'weight'      => '1',
        	'description' => __( 'Select icon from library.', 'js_composer' ),
		);

		vc_add_param( 'vc_icon', $settings);
	}

	public function registerCSS(){
		wp_register_style($this->iconLib, $this->getResourceDir().$this->iconLib.'/style.css');
		wp_enqueue_style($this->iconLib, $this->getResourceDir().$this->iconLib.'/style.css',array(),$this->getVersion());
	}		
		
	public function enqueuStyles(){
		wp_enqueue_style( $this->iconLib );
	}

	public function callFont($font){
	    switch ( $font ) {
	        case $this->iconLib : wp_enqueue_style( $this->iconLib );
	    }
	}
	
}