<?php

declare(strict_types=1);

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

final class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (\Throwable $e) {
            //
        });
    }

    public function render($request, \Throwable $exception): JsonResponse
    {
        /*
            if ($request->wantsJson()) {   //add Accept: application/json in request
                return $this->handleApiException($request, $exception);
            } else {
                $retval = parent::render($request, $exception);
            }

            return $retval;
            */

        return $this->handleApiException($request, $exception);
    }

    private function handleApiException($request, \Throwable $exception): JsonResponse
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse(mixed $exception): JsonResponse
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        $response = [];
        $response['success'] = false;
        $response['status'] = $statusCode;

        match ($statusCode) {
            401 => $response['message'] = 'Unauthorized',
            403 => $response['message'] = 'Forbidden',
            404 => $response['message'] = 'Not Found',
            405 => $response['message'] = 'Method Not Allowed',
            422 => [
                $response['message'] = 'Unprocessable Content',
                $response['errors'] = $exception->original['errors'],
            ],
            429 => $response['message'] = 'Too Many Requests',
            default => $response['message'] = ($statusCode == 500) ? 'Internal Server Error' : $exception->getMessage(),
        };

        /*
            if (config('app.debug')) {
                $response['trace'] = $exception->getTrace();
                $response['code'] = $exception->getCode();
            }
            */

        return response()->json($response, $statusCode);
    }
}
