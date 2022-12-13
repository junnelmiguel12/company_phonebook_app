<?php

namespace App\Repositories;

class BaseRepository
{
    protected $model;

    protected function errorResponse($error)
    {
        return [
            'code'    => $error->getCode(),
            'message' => $error->getMessage()
        ];
    }
}
