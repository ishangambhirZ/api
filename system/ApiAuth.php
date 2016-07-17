<?php

namespace rest\system;

class ApiAuth {
    const HASH_FUNCTION_SHA256  = 'sha256';
    
    private static $_available_hash_functions = array(
        self::HASH_FUNCTION_SHA256,
    );
    
    private $_request ;
    
    private $_request_data ;
    
    private $_api_key    = '';
    /**
     * class constructor
     * @method __construct
     * @access public
     */
    public function __construct() {
        include_once '../config.php';
        $this->_request         = new Request(); 
        $this->_request_data    = $this->_request->getALLRequestData();
        $this->_api_keys        = $config['api_key'];     
        
    }
    /**
     * 
     * @return boolean true if not a secure apis or token authenticated successfully
     * @throws AuthException
     */
    public function validate(){
        $result = false;
                if( empty($this->_request_data['user_id']) || empty($this->_request_data['ttl']) 
                        || ( empty($this->_request_data['token']) && empty($this->_request_data['key'] ))){
                    throw new \Exception('');
                }else{
                    //$this->_user    = 
                    
                    
                    if( isset($this->_request_data['token']) && isset($this->_user->user_id)){
                        $message = $this->_api_key.$this->_request_data['user_id']. $this->_request_data['ttl'];
                        $genrated_token = hash_hmac( self::HASH_FUNCTION_SHA256 , $message, $this->_user->password );
                        if( $this->_request_data['token'] === $genrated_token ){
                            $result  = true;
                        }else{
                            throw new \Exception('');
                        }
                    }
                    else{
                        throw new \Exception('');
                    }
                    
                }
                return $result ;
        }
}


