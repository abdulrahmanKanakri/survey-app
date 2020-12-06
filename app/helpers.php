<?php

use App\Classes\ApiResponse;
use App\Models\Media;
use App\Models\User\Employee;
use App\Models\User\Standard;
use App\Models\User\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

function searchInArray($array, $key, $value) {
    foreach($array as $arr) {
        if($arr[$key] == $value) {
            return $arr;
        }
    }
    return null;
}

function getCurrentDate($format = 'Y-m-d H:i:s', $timezone = 'Asia/Damascus') {
    return now($timezone)->format($format);
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

function castUserToEmployee($user)
{
    return $user ? Employee::find($user->id) : null;
}

function castUserToStandard($user)
{
    return $user ? Standard::find($user->id) : null;
}

function employee() {
    return castUserToEmployee(auth('api')->user());
}

function standard() {
    return castUserToStandard(auth('api')->user());
}

function storeFile(UploadedFile $file)
{
    $ext = $file->getClientOriginalExtension();
    $name = time() . '_' . Str::random(10);
    $type = $folder = '';
    foreach(Media::EXTENSIONS as $key => $extension) {
        if(in_array($ext, $extension)) {
            $type = $key;
            $folder = $type . 's';
            break;
        }
    }
    $path = $folder . '/' . $name . '.' . $ext;
    Storage::disk('public')->put($path, file_get_contents($file));
    return [
        'name' => $name,
        'ext' => $ext,
        'path' => $path,
        'type' => $type,
    ];
}
