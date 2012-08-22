<?php

class Match_IndexController extends Base{

    function index(){

        $this->template('content', 'hello.phtml');
        $this->show('main.tpl');
    
    }

    function exemple(){

        $this->_view->gotItFromParams = $this->params[0];
        $this->_view->otherParam      = $this->params[1];
        $this->template('content', 'exemple.phtml'); 
        $this->show('main.tpl');

    }

    function paginated(){

        $items = Items::getItems(); 
        $curPage = isset($this->params[0]) ? $this->params[0]:0;
        $p = new Pagination($items, $curPage);
        $p->before(APP_URL . '/mymodule/paginated')
          ->after('/anything/else/')
          ->startAtOne();
        $this->_view->pagination = $p;
        $this->_view->items = $items;
        $this->template('content', 'paginatedExemple.phtml'); 
        $this->show('main.tpl');
    
    }

}
