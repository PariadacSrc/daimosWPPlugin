<?php 

/**
*@package Daimos Project Library Wordpress Theme
*/

//Login Library
use Hybridauth\Hybridauth;

class socialConfig{

	private $config;

	public function setConfig($config){ $this->config=$config; }
	public function getConfig(){ return $this->config;}

	public function defaultSettings(){
		return [
			'callback' => '/',
			'providers' => [
				'Facebook' => [
					'enabled' => true, 
					'keys' => [ 
						'id'  => '2959144027511190', 
						'secret' => '1d01a4dc6d912442aaaeeda67914b93a'
					]
				],
				'Google' => [
					'enabled' => true, 
					'keys' => [ 
						'id'  => '409480116490-lvneeu535kbuadnl1u43ciaq7rl13rno.apps.googleusercontent.com', 
						'secret' => 'Ms5-FJvFjYQwmGMOeP_267vo'
					]
				] 
			]
		];
	}

	public function startLogin(){
		try{

		    $hybridauth = new Hybridauth($config);

		    $adapter = $hybridauth->authenticate('Facebook'); 
		    $isConnected = $adapter->isConnected();
		    $userProfile = $adapter->getUserProfile();
		    var_dump($userProfile);

		    $adapter->disconnect();
		}
		catch(\Exception $e){
		    echo 'Oops, we ran into an issue! ' . $e->getMessage();
		}
	}

}