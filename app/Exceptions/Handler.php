<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
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
        $this->renderable(function (ModelNotFoundException $e, $request) {
            if($request->is('api/*')){
                if ($exception instanceof ValidationException) {
                    throw new HttpResponseException(
                        response()->json([
                            'success' => false,
                            'message' => __('validation.fails'),
                            'errors'  => $this->restructureValidationErrors($exception->errors()),
                        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
                    );
                }
                 return parent::render($request, $exception);
            }
            
        });
         
    }
    

    
    private function restructureValidationErrors(array $errors)
    {
        $errorList = [];
        foreach ($errors as $attribute => $messages) {
            $errorList[] = [
                'attribute' => $attribute,
                'message'   => $messages[0],
            ];
        }
        return $errorList;
    }
}
