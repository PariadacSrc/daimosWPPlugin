<?php namespace Daim\Services;

//Components
use Daim\Helpers\mainHelper;

/**
*@package Daimos Project Library Wordpress Theme
*/

class templatesService{

	public function register(){

		$files_dir = DAIM_PLUGIN_DIR.'templates/theme';
		mainHelper::filesCalls($files_dir,array($this,'setTemplate'));
	}

	public function getTemplateName($dir){

		try {
			$reader = fopen($dir, 'r');
			
				$firtsLine = fgets($reader);

				$compStr = explode('*/', $firtsLine);
				$compStr = isset($compStr[0])? explode('/*', $compStr[0]) :false;
				$compStr = isset($compStr[1])? explode(':', $compStr[1]) :false;
				$compStr = isset($compStr[1])? trim($compStr[1]) :false;

			fclose($reader);

			return $compStr;

		} catch (Exception $e) {
			return false;
		}
	}

	public function setTemplate($dir, $file){

		$location = $dir.'/'.$file;

		if($tempName=$this->getTemplateName($location)){

			$obj = new class{

				public function registerTemplate ($templates){
					$templates[$this->file] = __( $this->name, DAIM_PLUG_DOMAIN );
					return $templates;
				}

				public function evalTemplate ($template){
					if ( is_page_template( $this->file ) ) {
						return $this->dir;
					}
					return $template;
				}
			};

			$obj->name = $tempName;
			$obj->dir  = $location;
			$obj->file = $file;

			add_filter( 'theme_page_templates',array($obj, 'registerTemplate'));
			add_filter( 'page_template', array($obj,'evalTemplate') , 99 );

		}
	}


}