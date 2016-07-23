<?php

include_once(__DIR__."/base/controller/ErrorController.php");
include_once(__DIR__."/app/controller/TMSController.php");

class Application
{
    public $query_string;
    public $url_controller ;
    public $url_action ;
    
    const base_url = 'http://localhost/TMS/index.php'  ;

    public function __construct()
    {

        $this->splitUrl();
    }

    public function init()
    {
      // echo 'controller '.$this->url_controller;
      // echo 'action '.$this->url_action;
      // exit();

      if($this->url_controller == null)
      {

           ErrorController::showError();
      }
      
     $controller_name = $this->url_controller;
     $controller_obj = new $controller_name();
     $controller_method = $this->url_action ;

     if(method_exists($controller_obj, $controller_method))
     {
      //echo 'test';exit();
      $controller_obj->$controller_method();
     }
     else
     {
       ErrorController::showError();
     }

    }

    private function splitUrl()
   {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->query_string = $url = str_replace(self::base_url, "", $actual_link);

       $url = trim($this->query_string, '/');
       $url = explode('/', $url);
       $this->url_controller = (isset($url[0]) ? $url[0] : null);
       $action = (isset($url[1]) ? $url[1] : null);
       if($action)
        $this->url_action = explode('?', $action)[0];
       
       
   }



    
}
