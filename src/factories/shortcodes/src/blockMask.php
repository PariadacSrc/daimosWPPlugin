<?php 

use Daim\Helpers\mainHelper;
/**
*@package Daimos Project Library Wordpress Theme
*/

class blockMask extends \Daim\Factories\shortCodeView{
	
	function __construct(){
		$this->setCodeName(DAIM_PRFX.'block_mask');
	}
	
	public function buildCode($atts,$content=null){
		$atts = shortcode_atts(array(
			'mask_color' 	=> 'rgba(0,0,0,0)',
			'mask_img' 		=> ''
		),$atts);

		return $this->genericLayoutRender($atts,DAIM__DEFAULT_COMP_FOLDER.'/blocks/daim_mask.php');

	}
	public function jsComposerMapCode(){
		return array(
			'name'        => 'Block Mask',
			'description' => '',
			'category'	  => DAIM_SHORTCODE_REF,
			'base'        => 'daim_slider_generic',
			'params'      => array(
				array(
					'type'       => 'colorpicker',
					'heading'    => __('Mask Background Color',DAIM_PLUG_DOMAIN),
					'param_name' => 'mask_color'
				),
				array(
					'type' 		=> 'attach_image',
					'heading'    => __('Mask Background Image',DAIM_PLUG_DOMAIN),
					'param_name' => 'mask_img'
				)
			),
		);
	}

	//Custom Shortcode Complements
}
