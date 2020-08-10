<?php namespace Daim\Services;

/**
*@package Daimos Project Library Wordpress Theme
*/

class assetsService{

	function __construct(){}

	public function register(){

		//Register Assets
		$this->enqueue_admin_assets();
		$this->enqueue_theme_assets();

	}

	//Enqueue Theme Assets
	/**
	* Admin Assets
	*/
	private function enqueue_admin_assets() {

		add_action( 'admin_enqueue_scripts', function(){

			//Fonts
			wp_enqueue_style( 'daim-main-admin-font', DAIM_PLUGIN_URL.'assets/fonts/daimos/style.css',array(),DAIM_PLUG_VERSION);
			//Styles
			wp_enqueue_style( 'normalize', DAIM_PLUGIN_URL.'assets/vendor/normalize-8.0.1/normalize.css',array(),DAIM_PLUG_VERSION);
			wp_enqueue_style( 'daimos-styles', DAIM_PLUGIN_URL.'assets/css/daimos-styles.css',array('normalize'),DAIM_PLUG_VERSION);
			wp_enqueue_style( 'daim-main-admin-styles', DAIM_PLUGIN_URL.'assets/css/admin/styles.css',array('daimos-styles'),DAIM_PLUG_VERSION);
			//Scripts
			wp_enqueue_script( 'daim-main-admin-scripts', DAIM_PLUGIN_URL.'assets/js/admin/daimos-scripts.js',array(),DAIM_PLUG_VERSION);
			wp_enqueue_script( 'daim-axios', DAIM_PLUGIN_URL.'assets/vendor/axios/axios.min.js',array(),DAIM_PLUG_VERSION,true);

		});
	}

	/**
	* Theme Assets
	*/
	private function enqueue_theme_assets() {

		add_action( 'wp_enqueue_scripts', function(){

			//Styles
			wp_enqueue_style( 'normalize', DAIM_PLUGIN_URL.'assets/vendor/normalize-8.0.1/normalize.css',array(),DAIM_PLUG_VERSION);
			wp_enqueue_style( 'daimos-styles', DAIM_PLUGIN_URL.'assets/css/daimos-styles.css',array(),DAIM_PLUG_VERSION);
			wp_enqueue_style( 'vendor-slick', DAIM_PLUGIN_URL.'assets/vendor/slick-1.8.1/slick.css',array(),DAIM_PLUG_VERSION);
			wp_enqueue_style( 'vendor-slick-theme', DAIM_PLUGIN_URL.'assets/vendor/slick-1.8.1/slick-theme.css',array(),DAIM_PLUG_VERSION);
			//wp_enqueue_style( 'datepicker', 'https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.0/dist/css/datepicker.min.css',array(),DAIM_PLUG_VERSION);
			wp_enqueue_style( 'daim-thm-styles', DAIM_PLUGIN_URL.'assets/css/theme/styles.css',array('daimos-styles'),DAIM_PLUG_VERSION);

			//Scripts
			wp_enqueue_script( 'vendor-slick-js', DAIM_PLUGIN_URL.'assets/vendor/slick-1.8.1/slick.min.js',array('jquery'),DAIM_PLUG_VERSION,true);
			wp_enqueue_script( 'daim-axios', DAIM_PLUGIN_URL.'assets/vendor/axios/axios.min.js',array(),DAIM_PLUG_VERSION,true);
			wp_enqueue_script( 'daim-qs', DAIM_PLUGIN_URL.'assets/vendor/qs-6.9.4/qs.js',array('daim-axios'),DAIM_PLUG_VERSION,true);
			wp_enqueue_script( 'validate-js', DAIM_PLUGIN_URL.'assets/vendor/validatejs-0.13.1/validate.min.js',array(),DAIM_PLUG_VERSION,true);


			wp_enqueue_script( 'daim-main-scripts', DAIM_PLUGIN_URL.'assets/js/theme/daimos-scripts.js',array('jquery'),DAIM_PLUG_VERSION);
			wp_enqueue_script( 'daim-form-actions', DAIM_PLUGIN_URL.'assets/js/theme/daimos-form-actions.js',array('jquery','daim-axios','daim-qs'),DAIM_PLUG_VERSION);
			wp_enqueue_script( 'daim-form-handler', DAIM_PLUGIN_URL.'assets/js/theme/daimos-form-handler.js',array('jquery','daim-axios','daim-qs'),DAIM_PLUG_VERSION);
			wp_enqueue_script( 'daim-modals', DAIM_PLUGIN_URL.'assets/js/theme/daimos-modals.js',array('daim-main-scripts'),DAIM_PLUG_VERSION);
			//wp_enqueue_script( 'daim-webpack', DAIM_PLUGIN_URL.'assets/builder/dist/daim-webpack.js',array(),DAIM_PLUG_VERSION);


			wp_localize_script( 'daim-main-scripts', 'wpApiSettings', array(
			    'root' => esc_url_raw( rest_url() ),
			    'nonce' => wp_create_nonce( 'wp_rest' )
			));

		});
	}

}