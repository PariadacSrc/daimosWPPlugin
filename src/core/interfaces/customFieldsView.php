<?php namespace Daim\Core\Interfaces;

/**
*@package Daimos Project Library Wordpress Theme
*/

abstract class customFieldsView{

	private $settings;
	private $sections;
	private $fields;

	public function setSettings($val){$this->settings=$val;}
	public function getSettings(){return $this->settings; }

	public function setSections($val){$this->sections=$val;}
	public function getSections(){return $this->sections;}

	public function setFields($val){$this->fields=$val;}
	public function getFields(){return $this->fields;}

	public function registerCustomFileds(){


		//Register Fields settings
		foreach ($this->getSettings() as $setting) {
			register_setting(
				$setting['option_group'],
				$setting['option_name'],
				(isset($section['callback']))?$section['callback']:[]
			);
		}

		//Register Fields sections
		foreach ($this->getSections() as $section) {
			add_settings_section(
				$section['id'],
				$section['title'],
				(isset($section['callback']))?$section['callback']:function(){},
				$section['page']
			);
		}

		//Register Fields fields
		foreach ($this->getFields() as $field) {
			add_settings_field(
				$field['id'],
				$field['title'],
				(isset($field['callback']))?$field['callback']:function(){},
				$field['page'],
				$field['section'],
				$field['args']
			);
		}

	}

}