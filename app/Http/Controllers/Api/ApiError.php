<?php

namespace App\Http\Controllers\Api;

class ApiError {
    public static function errorMessage($message, $code) {
        return [
            'data'=>[
                'msg' => $message,
                'code' => $code
            ]
            ];
    }
}
?>
