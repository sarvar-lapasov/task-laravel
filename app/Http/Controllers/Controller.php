<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function response($data):JsonResponse
    {
        return response()->json([
            'data' => $data,
        ]);
    }

    public function success(string $message, $data = null ):JsonResponse
    {
        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => $message ?? 'operation successfully',
            'data' => $data,
        ]);


    }public function error(string $message, $data = null ):JsonResponse
    {
        return response()->json([
            'success' => false,
            'status' => 'error',
            'message' => $message ?? 'error occurred',
            'data' => $data,
        ]);
    }
}
