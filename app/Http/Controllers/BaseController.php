<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Constants\ResponseConstants as response;

class BaseController extends Controller
{
    protected $service;

    protected function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, response::SUCCESS_CODE);
    }

    protected function sendError($error, $errorMessages = [], $code = response::REQUEST_NOT_FOUND)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];

        if(!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
