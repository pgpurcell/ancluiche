<?php

class View {
	
	public $viewvars;
	
    function __construct() {
    }

    function __set($name, $value){
		$this->viewvars[$name] = $value;
	}
	
    function __get($name){
		return isset($this->viewvars[$name]) ? $this->viewvars[$name] : new ViewVars;
    } 

    function t($key){
        echo Translate::t($key);
    }

	function render($script) {
		ob_start();
		include $script;
		$html = ob_get_clean();
		return $html;
	}
	
}
