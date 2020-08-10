<?php namespace Daim\Core\Interfaces;

/**
*@package Daimos Project Library Wordpress Theme
*/

abstract class wcCustomEndpoint{

	private $endpoint;
	public function setEndpoints($val){$this->endpoints=$val;}
	public function getEndpoints(){return $this->endpoints; }

	public function flushRules(){flush_rewrite_rules();}
	public function addEndpointRule(){

		foreach ($this->getEndpoints() as $endpoint => $actions) {
			add_rewrite_endpoint($endpoint, EP_ROOT | EP_PAGES);
		}
	}
	public function addQueryVar($vars){
		foreach ($this->getEndpoints() as $endpoint => $actions) {
			$vars[] = $endpoint;
	    	return $vars;
	    }
	}
	public function registerEndpoint(){
		$this->addEndpointRule();
		//add_action('init', [$this,'addEndpointRule']);
		add_filter('query_vars', [$this,'addQueryVar']);
		add_action('wp_loaded', [$this,'flushRules']);
		foreach ($this->getEndpoints() as $endpoint => $actions) {
			add_action('woocommerce_account_'.$endpoint.'_endpoint', $actions);
		}
	}
}