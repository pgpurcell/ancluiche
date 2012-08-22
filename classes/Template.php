<?php

class Template {
	
	public $templateVars = array ();
	public $view = NULL;
	
    function __construct() 
    {
    }
	
	function assign($varName, $value, $request = NULL) {
		//protect override?
		$scriptPath = $request['path'] . DS . $request['module'] . DS . 'views';
		if(!file_exists($scriptPath . DS . $value))
			$this->templateVars [$varName] = $value;
		else
			$this->templateVars [$varName] = $this->view->render($scriptPath . DS . $value);
	}

    function request($request){
        echo $this->front->run("$request[lang]/$request[module]/$request[controller]/$request[action]");
    }
    
    function t($key){
        echo Translate::t($key);
    }

    function __get($varname){
        return isset($this->templateVars[$varname]) ? $this->templateVars[$varname] : '';
    }

    function show($template) {
        foreach($this->templateVars as $key=>$value){
            $this->$key = $value;
        }
        include $template;
	}

}
