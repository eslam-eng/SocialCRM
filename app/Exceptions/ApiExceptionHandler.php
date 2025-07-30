<?php

namespace App\Exceptions;
use App\Helpers\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
class ApiExceptionHandler
{
    public static function handle(Exception $e, Request $request)
    {
        if (!$request->is('api/*')) {
            return null; // Let Laravel handle non-API requests normally
        }

        return match (true) {
            $e instanceof AuthenticationException => self::handleAuthenticationException($e, $request),
            $e instanceof AuthorizationException => ApiResponse::forbidden(message: 'Access denied.'),
            $e instanceof ValidationException => self::handleValidationException($e, $request),
            $e instanceof ModelNotFoundException => ApiResponse::notFound(message: 'Resource not found.'),
            $e instanceof MethodNotAllowedHttpException => ApiResponse::methodNotAllowed(message: 'Method not allowed.'),
            $e instanceof NotFoundHttpException => ApiResponse::notFound(message: 'Endpoint not found.'),
            $e instanceof ThrottleRequestsException => self::handleThrottleException($e, $request),
            default => self::handleGenericException($e, $request),
        };
    }
    private static function handleAuthenticationException(AuthenticationException $e, Request $request)
    {
        $message = $request->hasHeader('Authorization')
            ? 'Invalid or expired token.'
            : 'No authentication token provided.';

        return ApiResponse::unauthorized(message: $message);
    }



    private static function handleThrottleException(ThrottleRequestsException $e, Request $request)
    {
        return ApiResponse::tooManyRequests(
            message: 'Too many requests. Please try again later.',
            retryAfter: $e->getHeaders()['Retry-After'] ?? null
        );
    }

    private static function handleGenericException()
    {
        return ApiResponse::serverError(message: 'there is an error please try again later or contact with support for fast response');

    }
}
