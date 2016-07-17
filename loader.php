<?php

if (!defined('API_ROOT')) {
    define('API_ROOT', dirname(__FILE__));
}

function AtomAutoload($class_name) {
    if (!empty($class_name)) {
        $class_path = explode('\\', $class_name);
        if ('rest' === array_shift($class_path)) {
            $class = array_pop($class_path);
            $dir_path = implode('/', $class_path);
            $path = API_ROOT . '/' . $dir_path . '/' . $class . '.php';
            if (file_exists($path)) {
                require_once $path;
            } else {
                throw new \Exception("No class file found $path");
            }
        }
    }
}

spl_autoload_register('AtomAutoload');

?>