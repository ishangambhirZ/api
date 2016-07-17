<?php
namespace rest\dao;
use rest\dao\dao;
class product extends dao {
   public function __construct() {
      parent::construct();
   }
    public function getProductData() {
    
        $query = '';
        $result= $this->select($query);
        return $result;
    
    }
    


}
