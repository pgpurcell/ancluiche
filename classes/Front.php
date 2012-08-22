<?php

class Front{
    
    public $lang;
    protected $_module, $_controller, $_action;
    private $path, $locales = array();
    
    function __construct(){
    }

    function setLocales($locales){
        $this->locales = $locales;
    }

    function getLocales(){
        return $this->locales;
    }


    
    function setPath($path) {
        if (is_dir($path) === false) {
            throw new Exception ('repertoire de controlleur invalide: `' . $path . '`');
        }
        $this->path = $path;
        return $this;
    }

    public function run($route = NULL){
        if(is_null($route)){
            $route      = str_replace(array(ALIAS, substr($_SERVER['REQUEST_URI'], strpos($_SERVER['REQUEST_URI'], '?'))),
                                      array('', ''), 
                                      $_SERVER['REQUEST_URI']
                                  );
        }

        $requestArr = explode('/', trim( $route, '/') );

        if(!empty($requestArr[0]) &&
            in_array( $requestArr[0], $this->locales) ){
            $this->lang = array_shift($requestArr);
        }else{
            $this->lang = DEFAULT_LANG;    
        }
        
        if(!empty($requestArr[0]) && 
        	is_dir($this->path . DS . $requestArr[0])){
        	$this->_module = array_shift($requestArr);
        }else{ 
        	$this->_module = 'index';
        }

        if(!empty($requestArr[0]) && 
        	file_exists($this->path . DS . $this->_module . DS . ucfirst($requestArr[0]) . '.php')){
        	$this->_controller = array_shift($requestArr);
    	}else{
        	$this->_controller = 'index';
        }

        require_once $this->path . DS . $this->_module . DS . ucfirst($this->_controller) . '.php';

        $prefix     = $this->_module == 'index' ? '' : ucfirst($this->_module) . '_' ;
        $className  = $prefix . ucfirst($this->_controller) . 'Controller';
       	$controller = new $className;
       	
       	if(!empty($requestArr[0]) &&
	       	method_exists($controller, $requestArr[0]) ){
       		$this->_action = array_shift($requestArr);
    	}else if(method_exists($controller, 'index')){
       		$this->_action = 'index';
       	}else{
       		trigger_error('attention ' . $this->_module . ':' . $this->_controller . '::index()' . $this->_action . 
       		'n existe pas. Vous devez au moins creer un controleur index avec une methode index pour chaque module', 
       		E_USER_ERROR);
       	}

       	$controller->front      = $this;
       	$controller->lang       = $this->lang;
       	$controller->module     = $this->_module;
		$controller->controller = $this->_controller;
       	$controller->action     = $this->_action;
       	$controller->params     = $requestArr;
       	$controller->path       = $this->path;
       	$action                 = $this->_action;
       	return $controller->$action();
			
    }

}
