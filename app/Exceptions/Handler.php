<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Exceptions\HttpResponseException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (TokenMismatchException $e, $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Session ended. Please reload the page.',
                ], 419);
            }
    
            return redirect()
                ->back()
                ->withInput($request->except('_token'))
                ->with('error', 'Session ended. Please reload the page.');
        });
    }
    
    /**
     * 
     * @param Throwable $exception
     */
    public function report(Throwable $exception){
        /*if ($this->shouldReport($exception)) {
            Log::error($exception);
        }

        parent::report($exception);*/
    }
    
    /**
     * Summary of render
     * @param mixed $request
     * @param \Throwable $exception
     * @return mixed|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception){
        if ($exception instanceof ModelNotFoundException) {
            return response()->json(['error' => 'Resource not found'], 404);
        } elseif ($exception instanceof AuthenticationException) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }
        elseif ($exception instanceof QueryException) {
            return response()->json(['error' => 'Database error occurred'], 500);
        }
        elseif ($exception instanceof BindingResolutionException) {
            return response()->json(['error' => 'Dependency resolution error'], 200);
        }
        elseif ($exception instanceof TokenMismatchException) {
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Session ended. Please reload the page.',
                ], 419);
            }
    
            // For normal web requests
            return redirect()
                ->back()
                ->withInput($request->except('_token'))
                ->with('error', 'Session ended. Please reload the page.');
        }

        return parent::render($request, $exception);
    }
}
