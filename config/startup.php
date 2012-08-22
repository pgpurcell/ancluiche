<?php

//date_default_timezone_set('Europe/Paris');
if (isset($_SESSION))
{
	session_start();
}

function __autoload($class){
	if(file_exists(APP_DIR . "/models/$class.php"))
		require APP_DIR . "/models/$class.php";
	else
		require APP_DIR . "/classes/$class.php";
}

function filterData($data){
	if(is_array($data))
		$data = array_map("filterData", $data);
	else		
		$data = htmlentities($data, ENT_QUOTES, 'UTF-8');
	
	return $data;
}

$_POST   = array_map("filterData", $_POST);
$_GET    = array_map("filterData", $_GET);
$_COOKIE = array_map("filterData", $_COOKIE);

?>
