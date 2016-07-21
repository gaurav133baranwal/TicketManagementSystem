<?php 
class ErrorController
{	
 public static function showError() 
 {
 	echo 'ERROR 404!!! Page doesn\'t exit ';
	exit();
 }

}

ErrorController::showError();

?>