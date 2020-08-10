<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

class socialRegister{

	public function register(){

		$this->getSrc();

		add_filter( 'wpcf7_editor_panels', array($this,'bindCF7Panel') );

		add_action( 'rest_api_init', array($this,'apiList')) ;
		add_action('wpcf7_save_contact_form',array($this,'saveCF7Options'));
		//add_action( 'wpcf7_contact_form', array($this,'bindCF7Actions'), 10, 1 ); 
	}

	public function getSrc(){
		require_once('services/socialConfig.php');
	}

	public function bindCF7Panel($panels){

		$newPanel = array(
			'social-register' => array(
				'title' => __( 'User Actions', DAIM_PLUG_DOMAIN ),
				'callback' => array($this,'layoutCF7')
			)
		);
		
		$panels = array_merge($panels, $newPanel);

		return $panels;
	}

	public function actionsFields(){
		return[
			'enable_social_register' => "_".DAIM_PRFX."enable_social_register",
			'validate_token' => "_".DAIM_PRFX."validate_token",
			'bind_user_name' => "_".DAIM_PRFX."bind_user_name",
			'bind_email' => "_".DAIM_PRFX."bind_email",
			'bind_role' => "_".DAIM_PRFX."bind_role"
		];
	}

	public function layoutCF7($cf7){

		$postID = sanitize_text_field($_GET['post']);
		$tags = $cf7->scan_form_tags();

		$fields = $this->actionsFields();

		$enable = get_post_meta($postID, $fields["enable_social_register"], true);
		$validateToken = get_post_meta($postID, $fields["validate_token"], true);

		$bindUserName = get_post_meta($postID, $fields["bind_user_name"], true);
		$bindEmail = get_post_meta($postID, $fields["bind_email"], true);
		$bindRole = get_post_meta($postID, $fields["bind_role"], true);

		$listRoles = get_editable_roles();

		var_dump(self::baseDir());
		var_dump(self::getCompUrl());

		include_once('templates/admin_fields.php');

	}

	public function saveCF7Options($cf7){

		$postID = sanitize_text_field($_POST['post_ID']);
		$fields = $this->actionsFields();

		foreach ($fields as $field) {
			$val = sanitize_text_field($_POST[$field]);
			update_post_meta($postID , $field, $val);
		}
	}

	//
	public function bindCF7Actions($cf7){

		$ncf7 = array();
		foreach ((array)$cf7 as $key => $value) {$ncf7[] = $value;}

		$formID = $ncf7[0];
		$fields = $this->actionsFields();

		$enable = get_post_meta($formID, $fields["enable_social_register"], true);

		if($enable==='2'){
			add_filter( 'wpcf7_form_action_url', array($this,'urlCF7Action'), 10, 1 );
		}
		
	}

	public function urlCF7Action($url){

		//$current_url = home_url( add_query_arg( [], $GLOBALS['wp']->request ) );
		//$url = esc_url( wp_login_url( $current_url ) ) ;

		return $url;
	}

	public static function baseDir(){
		
		if ( defined( 'DAIM_LIBS_DIR' ) ) { 
			return DAIM_LIBS_DIR.'social_register';
		}
		return dirname(__FILE__);
	}

	public static function getCompUrl(){

		if ( defined( 'DAIM_LIBS_URL' ) ) { 
			return DAIM_LIBS_URL.'social_register';
		}
		return plugin_dir_url( self::baseDir() );
	}

	//API

	public function apiList(){

		register_rest_route( 'daimos/user', '/login', 
			array(
			    'methods' => 'POST',
			    'callback' => array($this,'loginUser'),
			)
		);

		register_rest_route( 'daimos/user/register', '/clients', 
			array(
			    'methods' => 'POST',
			    'callback' => array($this,'registerClients'),
			)
		);

		register_rest_route( 'daimos/user/register', '/dealers', 
			array(
			    'methods' => 'POST',
			    'callback' => array($this,'registerDealers'),
			)
		);

	}

	public function loginUser(){

		global $wpdb;
		
		$email = $wpdb->escape($_POST['userEmail']);
        $password = $wpdb->escape($_POST['passWord']);
        $remember = $wpdb->escape($_POST['rememberMe']);

        if($remember) $remember = "true";
		else $remember = "false";

		$login_data = array(
			'user_login' => $email,
			'user_password' => $password,
			'remember' => $remember
		);

		$user = wp_signon($login_data);
		if(!is_wp_error($user)){
			return ['action' =>'success', 'msg'=>__('Inicio de seción exitoso...')];
		}

		return ['action' =>'error', 'msg'=>__('Las credenciales no son validas')];

	}


	public function registerDealers(){return $this->registerUser('customers');}
	public function registerClients(){return $this->registerUser('repartidores');}

	public function registerUser($role){
		
        $email = $_POST['userEmail'];
        $password = wp_generate_password( 12, false );
        $name = $_POST['userName'].' '.$_POST['userLastName'];

        if ( !email_exists( $email ) ){
            // Create the user
            $userdata = array(
                'user_login' => $email,
                'user_pass' => $password,
                'user_email' => $email,
                'nickname' => reset($name),
                'display_name' => $name,
                'first_name' => $_POST['userName'],
                'last_name' => $_POST['userLastName'],
                'role' => $role
            );
            $user_id = wp_insert_user( $userdata );

            if ( !is_wp_error($user_id) ) {

                $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
                $message = "Welcome! Your login details are as follows:" . "\r\n";
                $message .= sprintf(__('Username: %s'), $username) . "\r\n";
                $message .= sprintf(__('Password: %s'), $password) . "\r\n";
                $message .= wp_login_url() . "\r\n";
                wp_mail($email, sprintf(__('[%s] Your username and password'), $blogname), $message);

                return ['action' =>'success', 'msg'=>__('Su usuario fue creado con exito...')];	
	        }    
	    }

	    return ['action' =>'error', 'msg'=>__('Ocurrio un error al crear su usuario, es probable que ya exista...')];

	}

}