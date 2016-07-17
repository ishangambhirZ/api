<?php

define('START_TIME', microtime(true));
require_once dirname(__FILE__) . '/api_prepare.php';

use rest\system\Request;
use rest\system\ObjectOperations;

try {

    $request = new Request();
    $request_data = $request->getALLRequestData();
    //$auth = new ApiAuth();
    //$auth->validate();
    $uri = $request_data['rquest'];
    $uri_parts = explode('/', $uri);
    $data = $message = '';
    $status = 200;
    if (!empty($uri_parts[0]) && !empty($uri_parts[1])) {
        $controller = $uri_parts[0];
        $method = $uri_parts[1];
        $controller_file = API_ROOT . '/controllers/' . $controller . '.php';
        $controller_full_qualified_name = "rest\\controllers\\$controller";
        if (file_exists($controller_file)) {
            require_once($controller_file);
            if (class_exists($controller_full_qualified_name)) {
                $parms = array_slice($uri_parts, 3);
                $class_reflection = new \ReflectionClass($controller_full_qualified_name);
                $data = $class_reflection->getMethod($method)->invokeArgs($class_reflection->newInstanceArgs(), $parms);
                $status = 200;
            }
        } else {
            $message = $uri . ':No request handler exists';
            $status = 404;
        }
    } else {
        $message = 'I think You missguided , you are not "' . CONTEXT . '"';
        $status = 404;
    }
} catch (Exception $e) {
    var_dump($e);
}
$empty = new stdClass();
$output = array(
    'response_time' => (microtime(true) - START_TIME),
    'message' => $message,
    'status' => $status,
    'response' => (empty($data))?$empty:$data
);

header('Content-Type: application/json');
echo ObjectOperations::json_encode(ObjectOperations::objectToArray($output));
exit;
?>