<?php namespace Daim\Helpers;

/**
*@package Daimos Project Library Wordpress Theme
*/

class shortCodeBuilder{

	private $params;
	private $comopentDir;

	public function setParams($params){ $this->params = $params; }
	public function getParams(){ return $this->params; }

	public function setComopentDir($comopentDir){ $this->comopentDir = $comopentDir; }
	public function getComopentDir(){ return $this->comopentDir; }

	function __construct($args,$dir){
		$this->setParams($args);
		$this->setComopentDir($dir);
	}

	public function callCustomComponent(){
		$comp = $this->getParams();
		include ($this->getComopentDir());
	}

}