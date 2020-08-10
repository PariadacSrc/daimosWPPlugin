<?php namespace Daim\Services;

/**
*@package Daimos Project Library Wordpress Theme
*/

class langService{

	private $langCookie;

	public function setLangCookie($cookie){$this->langCookie=$cookie;}
	public function getLangCookie(){return $this->langCookie;}


	//
	function __construct(){}
	public function register(){
		if($this->setNewCookie()){
			add_action( 'template_redirect', array($this,'setSingleTimeLang') );
		}
		add_action( 'after_setup_theme', array($this,'mainThemeTextDomain') );
		
	}

	//Extra Settings
	/**
	* Set Theme Text Domain
	*/
	public function mainThemeTextDomain(){
		load_theme_textdomain( DAIM_PLUG_DOMAIN, DAIM_THEME_DIR . '/lang' );
	}

	public function setNewCookie(){

		$cookie_name= 'daim_pref_lang';

		if(!isset($_COOKIE[$cookie_name])){

			$newLang = $this->browserPreferLang();
			setcookie($cookie_name, $newLang, time() + 3600, "/");
			$this->setLangCookie($newLang);
			return true;
		}

		return false;
	}
	public function setSingleTimeLang(){
		
		if($redirect = $this->polylangExtension($this->getLangCookie()) ){
			wp_redirect(get_permalink($redirect));
		}
	}

	public function browserPreferLang(){

		$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 5);
		$lang = str_replace('-','_',$lang);
		return $lang;
	}
	public function polylangExtension($lang){
		global $post;

		if(function_exists('pll_languages_list')){

			$lang = substr($lang, 0, 2);
			if( in_array($lang,pll_languages_list()) ){

				$newPost = pll_get_post($post->ID,$lang);
				if($newPost!==$post->ID) return $newPost;
			}
		}
		return false;
	}

}