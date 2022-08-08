<?php

namespace App\Http\Exception;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class CustomException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function render(Request $request): JsonResponse
    {
        return new JsonResponse(
            ['message' => $this->getMessage()],
            $this->getCode()
        );
    }
}
