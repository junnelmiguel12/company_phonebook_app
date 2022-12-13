<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class BaseService
{
    protected $repository;

    protected function apiResponse($code, $message)
    {
        return [
            'code'    => $code,
            'message' => $message
        ];
    }

    protected function doErrorLog($message, $description)
    {
        Log::error($message, $description);
    }
}
