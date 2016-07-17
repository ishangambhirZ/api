<?php

namespace clues\system\util;

use clues\system\util\exception\UtilException;
use clues\system\util\exception\UtilStatus;
use clues\system\Logger;

/**
 * This class is used for all object operations
 * @class ObjectOperations
 * @version 1.0
 * @category Utility
 * @package system/util
 * @author Aditya Mehrotra<aditya.mehrotra@shopclues.com>
 */
class ObjectOperations {

    /**
     * This method is used to get object item counts
     * @method getCount
     * @access public
     * @param object $object
     * @return int
     */
    public static function getCount($object) {
        $count = 0;
        foreach ($object as $value) {
            $count++;
        }
        return $count;
    }

    /**
     * This method is used to convert array in to object
     * @method arrayToObject
     * @access public
     * @param array $array
     * @return object standard class object
     */
    public static function arrayToObject(array $array) {
        if (!empty($array)) {
            $object = new \stdClass();
            foreach ($array as $key => $val) {
                if (is_array($val)) {
                    $val = self::arrayToObject($val);
                }
                $object->{$key} = $val;
            }
            return $object;
        } else {
            return null;
        }
    }

    /**
     * This method is used to convert object to array
     * @method objectToArray
     * @access public
     * @param object $object
     * @return array
     */
    public static function objectToArray($object) {
        return json_decode(self::json_encode($object), true);
    }

    /**
     * 
     * @param object $object
     * @return string json encoded string
     * @throws UtilException
     */
    public static function json_encode($object) {
        $encoded_string = json_encode($object);
        $error_code = json_last_error();
        if ($error_code == JSON_ERROR_NONE) {
            return $encoded_string;
        } else {
            switch ($error_code) {
                case JSON_ERROR_DEPTH:
                    $error_msg = 'Maximum stack depth exceeded';
                    break;
                case JSON_ERROR_STATE_MISMATCH:
                    $error_msg = 'Underflow or the modes mismatch';
                    break;
                case JSON_ERROR_CTRL_CHAR:
                    $error_msg = 'Unexpected control character found';
                    break;
                case JSON_ERROR_SYNTAX:
                    $error_msg = 'Syntax error, malformed JSON';
                    break;
                case JSON_ERROR_UTF8:
                    $error_msg = 'Malformed UTF-8 characters, possibly incorrectly encoded';
                    break;
                case JSON_ERROR_RECURSION:
                    $error_msg = 'The object or array passed to json_encode include recursive references and cannot be encoded';
                    break;
            }
            $exception_data = array();
            $exception_data['field1'] = 'json encode failed';
            $exception_data['error_name'] = "JSON_ENCODE";
            $additionalInfo = array();
            $additionalInfo['file'] = __FILE__;
            $additionalInfo['line'] = __LINE__;
            $additionalInfo['module'] = 'system';
            $additionalInfo['level'] = Logger::ERROR;
            $additionalInfo['method'] = __METHOD__;
            $exception_data['additional_data'] = $additionalInfo;
            throw new UtilException(UtilStatus::INVALID_INPUT, $exception_data);
        }
    }

}
