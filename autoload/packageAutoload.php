<?php

final class packageAutoload{

	protected static $_instance;
	private $route;

	function __construct(){
		$this->route=dirname(__FILE__).'/../src';
		$this->pluginPackages();
	}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	private function pluginPackages(){

		//Main Manager
		require_once $this->route.'/daimosManager.php';

		//Helpers
		require_once $this->route.'/helpers/mainHelper.php';

		//Services
		$this->loadDinamic($this->route.'/services');

		//Factories
		require_once $this->route.'/factories/factoryView.php';
		$this->loadDinamic($this->route.'/factories',array('src'));

		//Hooks
		$this->loadDinamic($this->route.'/hooks');


	}

	private function loadDinamic($route,$exclude=array()){
	
		if(file_exists($route)){
			
			$handler = opendir($route);

			while ($file = readdir($handler)){

				if(!in_array($file,$exclude)){

					if(is_file($route.'/'.$file)){
						if (strrpos($file, ".php") !== FALSE) {
							//echo "<pre>".$route.'/'.$file."</pre>";
							require_once ($route.'/'.$file);
						}
					}elseif(file_exists($route.'/'.$file) && strrpos($file, ".") === FALSE ){
						$this->loadDinamic($route.'/'.$file,$exclude);
					}

				}

			}

			closedir($handler);
		}
	}

}


