<?php

namespace App\Exceptions;

use ErrorException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Extend "unauthenticated" exception
     *
     * @param $request
     * @param AuthenticationException $exception
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws TickerException
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->wantsJson()) {
            throw new TickerException('Invalid token', JsonResponse::HTTP_FORBIDDEN);
        }

        return parent::unauthenticated($request, $exception);
    }

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(function (ErrorException $e, $request) {
            if ($request->wantsJson()) {
                throw new TickerException('Something went wrong', JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
            }
        });
    }
}
