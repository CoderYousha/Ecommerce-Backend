<?php

use Symfony\Component\HttpFoundation\Response;

if(!function_exists('success')){
    function success ($data = null, $message = null, $code = Response::HTTP_OK) {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $code);
    }
}

if(!function_exists('error')){
    function error ($message = null, $error = null, $code = Response::HTTP_BAD_REQUEST) {
        return response()->json([
            'message' => $message,
            'error' => $error
        ], $code);
    }
}