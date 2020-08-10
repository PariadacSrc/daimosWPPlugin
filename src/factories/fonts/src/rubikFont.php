<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

class rubikFont extends \Daim\Factories\fontsView{

	function __construct(){
		$this->setSettings(
			array(
				array(
					'font_family' => "Rubik",
				    'font_types' => '300 light regular:300:normal,400 regular:400:normal,500 bold regular:500:normal,600 bold regular:600:normal,700 bold regular:700:normal, 900 bold regular:900:normal',
				    'font_styles' => 'regular,900,bold',
				    'font_family_description' => __( 'Select font family', 'helper' ),
				    'font_style_description' => __( 'Select font styling', 'helper' ),
				)
			)
		);
	}

}
