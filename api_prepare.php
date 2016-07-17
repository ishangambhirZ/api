<?php

define('CONTEXT', 'api');
define('API_ROOT',  dirname(__FILE__));
include_once('loader.php');
include_once('config.php');

$GLOBALS['config']= $config;
if ($config['memcache']&&(!isset($GLOBALS['memcache']) || empty($GLOBALS['memcache']))) {
    $memcache = new Memcache;
    $memcache_servers = Registry::get('config.memcache_servers');
    
    foreach ($memcache_servers as $memcache_server) {
        $mem_conn = $memcache->addServer($memcache_server['host'], $memcache_server['port'], '', $memcache_server['weight']);
    }
    
    if ($mem_conn) {
        $GLOBALS['memcache'] = $memcache;
        $GLOBALS['memcache_status'] = $mem_conn;
    }
}
