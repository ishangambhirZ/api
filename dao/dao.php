<?php
namespace rest\dao;
class dao{
    private static $_conn;
    public function __construct() {
        if(!self::$_conn){
            self::$conn = new  mysqli($config['db']['host'], $config['db']['username'],$config['db']['password'],$config['db']['databse']);
            if(!self::$conn){
                throw new Exception("Error in connecting to db");
            }
        }
    }
    public function query($query) {
        $conn = self::$conn;
        $conn->query($query);
    }
    public function select($query) {
        $conn = self::$conn;
        $result = $conn->query($sql);
        if($result->num_rows() > 0){
            while($row = $result->fetch_assoc()){
                $final_result[] = $row; 
            }
        }
        return !empty($final_result)?$final_result:array();
    }
    public function insert($query) {
        $conn = self::$conn;
        $result = $conn->query($query);
        if($result) {
            return $conn->insert_id;   
        }
        return null;
    }
    public function update($query) {
        $conn = self::$conn;
        $conn->query($query);   
        return $conn->affected_rows;
       
    }
    public function del($query) {
        $conn = self::$conn;
        $conn->query($query);              
        return $conn->affected_rows;       
    }
}
