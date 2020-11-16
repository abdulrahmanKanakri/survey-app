<?php

namespace App\Classes;

class ApiResponse
{
    public static function success($data = null, $msg = 'success') {
        $response = ['success' => true];
        $response['message'] = $msg;
        $data === null ?: $response['data'] = $data;
        return response()->json($response, 200);
    }

    public static function error($data = null, $msg = 'error', $code = 422) {
        $response = ['success' => false];
        $response['message'] = $msg;
        $data === null ?: $response['data'] = $data;
        return response()->json($response, $code);
    }
}
