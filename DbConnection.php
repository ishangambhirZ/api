<?php

include 'db_config.php';

class DbConnection //create a class for make connection
{
    private $_connection;
    private static $_instance; //The single instance
    private $host;
    private $username;    // specify the sever details for mysql
    private $password;
    private $database;
    
    
    // Constructor
	private function __construct() {
	$host = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $database = $config['database'];
        $conn= mysql_connect($this->host,$this->username,$this->password);

        if(!$conn)// testing the connection
        {
            die ("Cannot connect to the database");
        }

        else
        {

            $this->_connection = $conn;

            echo "Connection established";

        }

     //   return $this->_connection;
	}
    
    
    
    public static function getInstance() {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self();
		}
		return self::$_instance;
	}

    public function connectToDatabase() // create a function for connect database
    {       
            return $this->_connection;
    }

    public function selectDatabase() // selecting the database.
    {
        mysql_select_db($this->database);  //use php inbuild functions for select database

        if(mysql_error()) // if error occured display the error message
        {

            echo "Cannot find the database ".$this->database;

        }
         echo "Database selected..";       
    }

    public function closeConnection() // close the connection
    {
        mysql_close($this->_connection);
        self::$_instance = NULL;
        echo "Connection closed";
    }

}

?>