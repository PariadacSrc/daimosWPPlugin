<?php 

/**
*@package Daimos Project Library Wordpress Plugin
*/

if(!class_exists('DaimosManager')): 


	final class DaimosManager{

		//Main Attributes
		protected static $_instance;
		private $settigs;
		private $activeExtension;
		
		public function getSettings(){
			return $this->settigs;
		}

		public function setActiveExtension($bool){$this->activeExtension=$bool;}
		public function getActiveExtension(){return $this->activeExtension;}

		function __construct($args=null){
			global $Daimos;
			$this->setup_constants();
			//Register plugin Services
			$this->registerClasses($this->getServices());
			//Register Custom WP Hooks
			$this->registerClasses($this->getHooks());
			//Extension Theme
			$this->getExtencionAutoload();

			$Daimos = $this;

			$this->settigs = array(
				'post_types' 	=> (new postTypeFactory()),
				'short_codes'	=> (new shortCodeFactory()),
				'icons_libs' 	=> (new iconsFactory()),
				'fonts'  		=> (new fontsFactory()),
				'metaboxes' 	=> (new metaboxFactory())
			);

			$Daimos = $this;
		}

		//Default Actions
		/**
		* Return Self Instance 
		*/
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function getServices(){
			return [
				pluginService::class,
				assetsService::class,
				langService::class,
				adminService::class,
				templatesService::class
			];
		}

		public function getHooks(){
			return [
				componentsHooks::class
			];
		}

		public function getExtencionAutoload(){
			if(file_exists(THM_EXTENSION.'autoLoadService.php')){
				require_once(THM_EXTENSION.'autoLoadService.php');
				$service = new autoLoadService();
				$service->register();
				$this->setActiveExtension(true);
			}else{
				$this->setActiveExtension(false);
			}
		}

		public function registerClasses($nodes, $action='register'){
			foreach ($nodes as $class) {
				$service = new $class();

				if(method_exists($service, $action)){$service->register();}
			}
		}

		/**
		* Set all main constants for Plugin
		*/
		private function setup_constants() {

			// Plugin Version.
			if ( ! defined( 'DAIM_PLUG_VERSION' ) ) { define( 'DAIM_PLUG_VERSION', '1.000.0012' ); }
			
			// Plugin Root File.
			if ( ! defined( 'DAIM_PLUGIN_FILE' ) ) { define( 'DAIM_PLUGIN_FILE', __FILE__ );}

			// Plugin Folder Path.
			if ( ! defined( 'DAIM_PLUGIN_DIR' ) ) { define( 'DAIM_PLUGIN_DIR', plugin_dir_path( DAIM_PLUGIN_FILE ) ); }

			// Plugin Folder URL.
			if ( ! defined( 'DAIM_PLUGIN_URL' ) ) { define( 'DAIM_PLUGIN_URL', plugin_dir_url( DAIM_PLUGIN_FILE ) ); }

			// Plugin Basename aka: "daimos-project/src/daimosManager.php".
			if ( ! defined( 'DAIM_PLUGIN_BASENAME' ) ) { define( 'DAIM_PLUGIN_BASENAME', plugin_basename( DAIM_PLUGIN_FILE ) ); }

			// Plugin Main Prefix
			if ( ! defined( 'DAIM_PRFX' ) ) { define( 'DAIM_PRFX', 'daim_' ); }

			// Plugin Main Text Domain
			if ( ! defined( 'DAIM_PLUG_DOMAIN' ) ) { define( 'DAIM_PLUG_DOMAIN', 'daimos-text-domain' ); }

			//Extra Const
			if ( ! defined( 'DAIM__DEFAULT_COMP_FOLDER' ) ) { define( 'DAIM__DEFAULT_COMP_FOLDER', DAIM_PLUGIN_DIR.'components/' ); }
			if ( ! defined( 'DAIM_SHORTCODE_REF' ) ) { define( 'DAIM_SHORTCODE_REF', __('Shortcuts Daimos',DAIM_PLUG_DOMAIN) ); }

			/*---------------------------------Theme Extension*/
			if ( ! defined( 'THM_VER' ) ) { define( 'THM_VER', wp_get_theme()->get( 'Version' ) ); }
			if ( ! defined( 'THM_DIR' ) ) { define( 'THM_DIR', get_stylesheet_directory().'/' ); }
			if ( ! defined( 'THM_URL' ) ) { define( 'THM_URL', get_stylesheet_directory_uri().'/' ); }
			if ( ! defined( 'THM_EXTENSION' ) ) { define( 'THM_EXTENSION', THM_DIR.'daim-extension/' ); }
			if ( ! defined( 'THM_EXT_URL' ) ) { define( 'THM_EXT_URL', THM_URL.'daim-extension/' ); }

		}
		
	}

endif;