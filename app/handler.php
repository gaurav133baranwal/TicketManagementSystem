<?php

$controller =  $_GET['controller'];
if(isset($controller))
{
	include(__DIR__."/controller/".$controller.".php");
	$method = $_GET['action'];
	$cont = new $controller();
	$cont->$method($_POST);
}




?>