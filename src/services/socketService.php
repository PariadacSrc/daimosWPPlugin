<?php namespace Daim\Services;

/**
*@package Daimos Project Library Wordpress Theme
*/

//Ratchet Socket Library
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

//Socket Class
use Daim\Core\classSocket;

class socketService{

	public function register(){
		$this->validateWS();
	}

	public function registerActionsPorts(){
		add_action('wp_ajax_socket_test',array($this,'validateWS'));
	}

	public function validateWS(){
		$server = IoServer::factory(
		    new HttpServer(
		        new WsServer(
		            new classSocket()
		        )
		    )
		);

		$server->run();
		wp_die();
	}

}