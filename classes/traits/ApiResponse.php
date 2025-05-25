<?php

class ApiResponse {
public static function ok($message, $data = []) {
return self::success($message, $data, 200);
}

public static function created($message, $data = []) {
return self::success($message, $data, 201);
}

public static function success($message, $data, $statusCode = 200) {
http_response_code($statusCode);
return [
'status' => 'success',
'statusCode' => $statusCode,
'message' => $message,
'data' => $data
];
}

    public static function error($message, $statusCode = 500) {
        http_response_code($statusCode);
        $messages = is_array($message) ? $message : [$message];

        return [
            'status' => 'error',
            'statusCode' => $statusCode,
            'message' => $messages
        ];
    }


public static function notFound($message) {
return self::error($message, 404);
}

public static function unauthorized($message) {
return self::error($message, 401);
}

public static function forbidden($message) {
return self::error($message, 403);
}

public static function badRequest($message) {
return self::error($message, 400);
}

public static function internalServerError($message) {
return self::error($message, 500);
}
}
