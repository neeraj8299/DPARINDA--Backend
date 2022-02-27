<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $messageArr = [];
        $statusCode = 500;
        $isError = false;
        $error_code = 'error_code';

        if ($exception instanceof MethodNotAllowedHttpException) {
            $messageArr = [
                $error_code => config('api-config.MESSAGES.HTTP_METHOD_NOT_ALLOWED_MESSAGE'),
            ];
            $statusCode = config('api-config.STATUS_CODE.HTTP_METHOD_NOT_ALLOWED_CODE');
            $isError = true;
        } else if ($exception instanceof NotFoundHttpException) {
            $messageArr = [
                $error_code => config('api-config.MESSAGES.NOT_FOUND_REQUEST'),
            ];
            $statusCode = config('api-config.STATUS_CODE.NOT_FOUND');
            $isError = true;
        } else if ($exception instanceof ValidationException) {
            $messageArr = [
                $error_code => config('api-config.MESSAGES.UNPROCESSABLE_ENTITY'),
                'error_payload' => $exception->errors(),
            ];
            $statusCode = config('api-config.STATUS_CODE.UNPROCESSABLE_ENTITY');
            $isError = true;
        } else if ($exception instanceof TokenExpiredException || $exception instanceof TokenInvalidException || $exception instanceof JWTException) {
            $messageArr = [
                $error_code => config('api-config.MESSAGES.UNAUTHORIZED_REUQUEST'),
            ];
            $statusCode = config('api-config.STATUS_CODE.UNAUTHORIZED');
            $isError = true;
        } else if ($exception instanceof UnauthorizedException) {
            $messageArr = [
                $error_code => config('api-config.MESSAGES.INVALID_CREDENTIALS'),
            ];
            $statusCode = config('api-config.STATUS_CODE.UNAUTHORIZED');
            $isError = true;
        } else if ($exception instanceof BadRequestException) {
            $messageArr = [
                $error_code => config('api-config.MESSAGES.BAD_REQUEST'),
            ];
            $statusCode = config('api-config.STATUS_CODE.BAD_REQUEST');
            $isError = true;
        } else {
            $messageArr = [
                $error_code => "Unable To Process Your Request",
            ];
            $statusCode = 500;
        }

        return response()->json($messageArr, $statusCode);
    }
}
