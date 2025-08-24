<?php

namespace App\Traits;

trait APIResponseTrait {
    public function successResponse($data = [], $message = 'Success', $code = 200) {
        $response = [
            'success' => true,
            'message' => $message,
        ];
        if (!empty($data)) {
            $response['data'] = $data;
        }
        return response()->json($response, $code);
    }
    public function errorResponse($errors = [], $message = 'Error', $code = 500) {
        $code = ($code < 100 || $code > 599) ? 500 : $code;
        $response = [
            'success' => false,
            'message' => $message,
        ];
        if (!empty($errors)) {
            $response['errors'] = $errors;
        }
        return response()->json($response, $code);
    }
}
