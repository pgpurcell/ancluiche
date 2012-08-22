<?php

abstract class Base {
	
	public $lang, $module, $controller, $action, $path;
	protected $_t, $_view, $_path;	
	
	function __construct() {
		$this->_view = new View;
        $this->_t = new Template;	
	}
	
	protected function template($var, $value, $request = null ){
		if(is_null($request)){
			$request['module']     = $this->module;
			$request['controller'] = $this->controller;
			$request['action']     = $this->action;
			$request['path']       = $this->path;
		}
		$this->_t->view = $this->_view;
		$this->_t->assign($var, $value, $request);
	}
	
	protected function show($templateFile){
        $this->_t->front = $this->front;
		$this->_t->show(APP_DIR . '/templates/' . $templateFile);
    }

    protected function authenticate($role, $callbackUrl = '/login'){
        $callbackUrl = APP_URL . $callbackUrl;
        if(!isset($_SESSION[$role]))
            header("Location: $callbackUrl");
    }
}
