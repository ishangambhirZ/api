<?php
namespace rest\controllers;
use rest\dao\products as products_dao;
class products
{
    private $_dao; 
    public function __construct() {
        $this->_dao = new products_dao();    
    
    }
	public function add()
	{
		print_r($_REQUEST);
		echo "i am in addd";
		die;
	}
	public function remove()
	{
		echo "i am in remove";
		die;
    }
    public function get() {
            
    
    }


}
