<?php namespace Daim\Factories;

/**
*@package Daimos Project Library Wordpress Theme
*/

abstract class postTypeView{
	private $prefix;

	public function getPrefix(){return $this->prefix;}
	public function setPrefix($prefix){$this->prefix=$prefix;}

	//Standar Methods
	abstract public function settings();
	abstract public function handlers();

}