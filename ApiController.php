<?php


class ApiController extends REST  {
    
    public function __construct(){
	    parent::__construct();				// Init parent contructor
    }
    
    public function addProduct(){
                   if($this->get_request_method() != "GET"){

				$this->response('',406);
		   }   
                   $params = $this->_request;
    }
    
    public function editProduct(){
                   if($this->get_request_method() != "POST"){

				$this->response('',406);
		   }        
                   $params = $this->_request;
    }
    
    public function deleteProduct(){
                   if($this->get_request_method() != "POST"){

				$this->response('',406);
		   } 
                   $params = $this->_request;
    }
    
    public function searchProduct(){
                   if($this->get_request_method() != "GET"){

				$this->response('',406);
		   } 
                   $params = $this->_request;
    }
    
}
?>

