<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

class postFooter extends \Daim\Factories\metaboxView{

	function __construct(){
		$this->setPostList(['post','page']);
		$this->setPrefix(DAIM_PRFX.'post_footer');
		$this->setSettings([
			'title' => __('Template footer',DAIM_PLUG_DOMAIN),
			'field_text' => __('Select post footer template',DAIM_PLUG_DOMAIN)
		]);
	}

	public function metaBuild($post){

		$field_title = $this->getSettings()['field_text'];
		$field_name = $this->getPrefix();
		$field_id = $this->getPrefix();
		$default_value = ($this->getMetaval($post->ID))? $this->getMetaval($post->ID)->ID: 0;

		$field_options = [(object)['ID'=>0,'post_name'=>_('Please select a footer...')]];
		$field_options = array_merge($field_options,get_posts(array('post_type'=>DAIM_PRFX.'footers')));
		$field_options = array_map(['\Daim\Helpers\mainHelper','setMapOption'], $field_options);

		include (DAIM_PLUGIN_DIR.'templates/admin/components/standar_field.php');

	}

	public function renderActions(){
		add_action( 'daim_post_footer', array($this,'renderPostFooter'),5,1 );
	}


	public function renderPostFooter($id){
		$this->renderPostMeta($id,DAIM_PRFX.'footers');
	}

}
