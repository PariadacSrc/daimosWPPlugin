<?php namespace Daim\Factories;

use Daim\Helpers\mainHelper;
/**
*@package Daimos Project Library Wordpress Theme
*/

abstract class factoryView{

	//Main Attributes
	private $list;

	//Settings
	public function setList($list){
		if(is_array($list)){
			$this->list=$list;
		}
	}
	public function getList(){ return $this->list;}

	//Main Methods
	public function actionHandler($files_dir){
		$this->setList(array());
		mainHelper::filesCalls($files_dir,array($this,'registerAction'));
	}
	
	public function registerAction($dir, $file){
		require_once $dir.'/'.$file;
		$class = '\\'.basename($file,".php");
		$obj = new $class();

		//Setting List
		$newList = $this->getList();
		$newList[] = $obj;
		$this->setList($newList);

		$this->triggerHandler($obj);
	}

	public function registerExtension($dir){
		global $Daimos;

		if($Daimos->getActiveExtension()){
			//Theme Extension Types
			$this->actionHandler($dir);
		}
	}

	abstract public function triggerHandler($obj);
}