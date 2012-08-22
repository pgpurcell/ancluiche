<?php

class Authentified extends Base{

    function __construct(){
        parent::__construct();
        $this->authenticate('admin', '/login');
    }

}
