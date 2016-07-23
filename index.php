<?php

require_once( __DIR__."/Application.php");

//echo "http://".$_SERVER ["HTTP_HOST"].$_SERVER["REQUEST_URI"];

 $task_app = new Application();
 $task_app->init();
?> 