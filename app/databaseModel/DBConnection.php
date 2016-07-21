<?php

include_once(__DIR__."/../../config.php");
class DBConnection
{
    private $_connection;
    private static $_instance; 

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new DBConnection();
        }
        return self::$_instance;
    }

    private function __construct()
    {
        $_host = DBSERVER;
        $_username = DBUSERNAME ;
        $_password = DBPASSWORD;
        $_database = DBNAME;

        print_r(array($_host ,$_password));

        $this->_connection   = mysqli_connect($_host,$_username,$_password,$_database);

        if(mysqli_connect_errno())
        {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        else
        {
            echo "connected to database";
        }

    }

    public function getConnection()
    {
    return $this->_connection;
    }
}
