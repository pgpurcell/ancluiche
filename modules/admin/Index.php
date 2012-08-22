<?php

/**
 * this class show an exemple of how to make a controller authentified
 * check ~/classes/authentified.php
 **/ 

class Admin_IndexController extends Authentified{

    function index(){

        $this->template('content', 'adminView.phtml');
        $this->template('exemple', '<i>you can pass</i> a string as <b>second parameter</b> of the template function');
        $this->show('admin.tpl');

    }

}
