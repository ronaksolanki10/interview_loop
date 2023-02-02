<?php

namespace App\Exceptions;

use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            return $this->handleApiException($exception);
        }

        return parent::render($request, $exception);
    }

    protected function handleApiException(Throwable $exception)
    {
        switch ($exception) {
            case $exception instanceof MethodNotAllowedException:
                $httpCode = 500;
                $message = trans('exception.method_not_allowed');
                break;
            case $exception instanceof NotFoundHttpException:
                $httpCode = 404;
                $message = trans('exception.not_found');
                break;
            case $exception instanceof HttpException:
                $httpCode = 500;
                $message = trans('exception.something_went_wrong');
                break;
            case $exception instanceof AuthenticationException:
                $httpCode = 401;
                $message = trans('exception.session_expired');
                break;
            case $exception instanceof ValidationException:
                $errors = collect($exception->errors())->first();
                $httpCode = 422;
                $message = $errors[0];
                break;
            default:
                $httpCode = 500;
                $message = trans('exception.something_went_wrong');
                break;
        }

        return response()->json([
            'message' => $message,
        ], $httpCode);
    }
}
