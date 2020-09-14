<?php

function searchInArray($array, $key, $value) {
    foreach($array as $arr) {
        if($arr[$key] == $value) {
            return $arr;
        }
    }
    return null;
}

function getCurrentDate($format = 'Y-m-d H:i:s') {
    return now('Asia/Damascus')->format($format);
}

function getIPAddress() {  
    //whether ip is from the share internet  
    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  
        $ip = $_SERVER['HTTP_CLIENT_IP'];  
    }  
    //whether ip is from the proxy  
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
    }  
    //whether ip is from the remote address  
    else{  
        $ip = $_SERVER['REMOTE_ADDR'];  
    }  
    return $ip;  
}

function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}
