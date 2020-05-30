<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

class debugHelper{

	public static function call(...$params){
		echo '<pre>';
			var_dump(...$params);
		echo '</pre>';
	}

	public static function hiddeDebug(...$params){
		echo '<div style="display:none">';
			self::call(...$params);
		echo '</div>';
	}
}