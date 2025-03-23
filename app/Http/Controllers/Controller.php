<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;

class Controller {
    
    use AuthorizesRequests, ValidatesRequests;
    
    public const HTTP_SUCCESS_STATUS = 200;
    public const HTTP_NO_BODY_SUCCESS_STATUS = 201;
    public const HTTP_BAD_REQUEST_STATUS = 400;

    public function buildSuccessResponse(mixed $data): JsonResponse {
        return response()->json(
            $data,
            self::HTTP_SUCCESS_STATUS,
            [],
            JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT
        );
    }
    
    public function buildBadRequestResponse(string $errorMessage): JsonResponse {
        return response()->json(
            ['message' => $errorMessage],
            self::HTTP_BAD_REQUEST_STATUS
        );
    }
}
