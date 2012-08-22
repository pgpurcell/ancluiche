<?php

class User{

    function authenticate(){
        //in a real world application you should authenticate against the database
        //the framework provides a PDO abstration layer with 3 methods
        //Db::one gets the instance via singleton queries the query passed in param and returns one row
        //Db::all gets the instance via singleton queries the query passed in param and returns all the rows
        //Db::save is a simple active record

        if($_POST['login']==='admin' && $_POST['password']==='admin'){
            $_SESSION['admin'] = array('login'=>'admin', 'name'=>'brown', 'nick'=>'charlie', 'mail'=>'charliebrown@peanuts.com');
            return true;
        }
        return false;
    }

}
