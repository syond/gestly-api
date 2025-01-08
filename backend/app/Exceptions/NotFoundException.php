<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception {
    public function __construct($message = 'Resource not found', $code = 404)
    {
        parent::__construct($message, $code);
    }

    public function render($request) {
        return response()->json([
            'status' => 'error',
            'message' => $this->getMessage(),
            'errors' => [
                'code' => $this->getCode(),
                'details' => $this->getTrace(),
            ],
        ], $this->getCode());
    }
}