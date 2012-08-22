<?php

 /**
  * note that your class must be named like the controller you want to execute followed by 'Controller'
  * and must extends Base
  * if you are in a module which is not index(by default) your class name must be preceded by the module name
  * eg : Mymodule_IndexController
  * then call simply your function using actions name
  **/  

class IndexController extends Base{

    function index(){
        $this->_view->whereIam = __FILE__;
		$this->_view->exemplevar = "hello minimal MVC";
		$this->template("content", "indexView.phtml"); 
		$this->show('main.tpl');
	}

    function forward(){
        $this->front->run($this->lang . '/index/index/target');
    }

    function target(){
        $this->template('content', 'forward.phtml');
        $this->show('main.tpl');
    }

    function requestfromtemplate(){
        $this->_view->testvar = 'the testvar value';
        //we set something with the template function
        $this->template('query', 'fromtemplate.phtml');
        //we return the template var we have set above (query), which was the 1st param 
        //passed to the template function 
        return $this->_t->templateVars['query'];
    }

}
