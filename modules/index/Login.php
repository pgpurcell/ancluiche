<?php

class LoginController extends Base{

    function index(){
        if(isset($_POST['login'])){
            $result = User::authenticate();
            $location = APP_URL . '/admin';
            if($result)
                header("Location: $location");
        }

        $this->template('content', 'loginForm.phtml');
        $this->show('main.tpl');

    }

}
