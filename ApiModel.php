<?php

include 'DbConnection.php';

class ApiModel{
    
    private $mysql;
            
    function __construct() {
        $db = DbConnection::getInstance();
        $this->mysql = $db->getConnection();
    }
    
    public function addProductData(){
        
    }
    
    public function editProductData(){
        
    }
    
    public function deleteProductData(){
        
    }
    
    public function searchProductData(){
        
    }
    
    
}


?>
