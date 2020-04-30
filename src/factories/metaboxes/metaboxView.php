<?php  

/**
*@package Daimos Project Library Wordpress Theme
*/

abstract class metaboxView{

	private $postList;
	private $prefix;
	private $settings;

	public function setPostList($postList){
		if(is_array($postList)){
			$this->postList=$postList;
		}
	}
	public function getPostList(){ return $this->postList;}

	public function setSettings($settings){
		if(is_array($settings)){
			$this->settings=$settings;
		}
	}
	public function getSettings(){ return $this->settings;}

	public function setPrefix($prefix){ $this->prefix=$prefix; }
	public function getPrefix(){ return $this->prefix;}

	/*
	* Main Handler
	*/
	public function registerHandlers(){

		add_action('add_meta_boxes', array($this,'metaRecoder'));
		add_action('save_post', array($this,'metaSave'));
	}

	public function metaRecoder(){

		foreach ($this->getPostList() as $type) {
			add_meta_box(
	            $this->getPrefix(),
	            $this->getSettings()['title'],
	            array($this,'metaBuild'),
	            $type
	        );
		}
	}
	public function metaSave($id){

	    if (array_key_exists($this->getPrefix(), $_POST)) {
	        update_post_meta(
	            $id,
	            $this->getPrefix(),
	            $_POST[$this->getPrefix()]
	        );
	    }
	}

	public function getMetaval($id){
		$metaVal = get_post_meta($id,$this->getPrefix());
		return (count($metaVal)>0)? get_post($metaVal[0]):false;
	}

	public function renderPostMeta($id,$type){

		global $wp, $post;

		$metaVal = get_post_meta($id,$this->getPrefix());

		if(count($metaVal)>0){

			$args = ['p'=>intval($metaVal[0]),'post_type'=>$type];
			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {
                    
                while ( $query->have_posts() ) {
                	$query->the_post();
                    $post = get_post();

                	mainHelper::getRenderVCStyles($post->ID);
					echo do_shortcode($post->post_content);

                }
                
                wp_reset_postdata();
                $post = get_post();
            }
		}
	}

	abstract public function metaBuild($post);
	abstract public function renderActions();
	
}