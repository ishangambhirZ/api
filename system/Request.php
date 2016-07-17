<?php

namespace rest\system;

class Request {

    const PORT_SECURE_PROTOCOL = 443;
    private $getParams;
    private $postParams;
    private $serverData;

    public function __construct() {
        $this->getParams    = isset($_GET) && !empty($_GET) ? $_GET:array();
        $this->postParams   = isset($_POST) && !empty($_POST) ? $_POST:array();
        $this->serverData   = isset($_SERVER) && !empty($_SERVER) ? $_SERVER:array();        
        $this->requestParam = isset($_REQUEST) && !empty($_REQUEST) ? $_REQUEST:array();
    }
    
    public function requestRequestParams($fieldName = '') {
        return ($fieldName == '') ? $this->requestParam : $this->requestParam[$fieldName];
    }

    public function getRequestParams($fieldName = '') {

        return ($fieldName == '') ? $this->getParams : $this->getParams[$fieldName];
    }

    public function postRequestParams($fieldName = '') {
        return ($fieldName == '') ? $this->postParams : $this->postParams[$fieldName];
    }

    public function getRequestType() {
        return $this->serverData['REQUEST_METHOD'];
    }

    public function getUserAgent() {
        return $this->serverData['HTTP_USER_AGENT'];
    }

    public function getServerData($fieldName) {
        return ($fieldName == '') ? $this->serverData : $this->serverData[$fieldName];
    }

    /**
     * Read data from `php://input`. Useful when interacting with JSON
     * Getting input with a decoding function:
     * $RequestObj->getRawPostData("json_decode")
     * $RequestObj->getRawPostData("json_decode",true)
     * Any additional parameters are applied to the callback in the order they are given.
     * @method getRawPostData
     * @access public
     * @return The decoded/processed request data.
     */
    public function getRawPostData() {
        $fh = fopen('php://input', 'r');
        $input = stream_get_contents($fh);
        fclose($fh);
        $args = func_get_args();
        if (!empty($args)) {
            $callback = array_shift($args);
            array_unshift($args, $input);
            return call_user_func_array($callback, $args);
        }
        return $input;
    }

    public function getALLRequestData() {
        $raw = $this->getRawPostData();
        $request_body = !empty($raw) ? json_decode($raw, true) : array();
        $_temp = json_last_error();
        if (JSON_ERROR_NONE != $_temp) {
            $request_body = array();
        }
        return array_merge( $this->postParams  , $request_body , $this->getParams );
    }

    public function isHTTPSRequest() {
        return ( $this->getServerData('SERVER_PORT') == self::PORT_SECURE_PROTOCOL ) ? true : false;
    }

    /* AJAX check  */

    public function isAjaxRequest() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

}
