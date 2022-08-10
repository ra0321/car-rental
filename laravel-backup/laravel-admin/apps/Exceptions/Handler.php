<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use App\Traits\Errors\ErrorLogTrait;
use BadMethodCallException;
use ErrorException;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PDOException;
//use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Intervention\Image\Exception\NotWritableException;
use Throwable;

/**
 * Class Handler
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler
{
	use ApiResponser, ErrorLogTrait;
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
        'password',
        'password_confirmation',
    ];

    /**
     * @param Throwable $exception
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * @param Request $request
     * @param Throwable $exception
     * @return JsonResponse|Response
     * @throws Throwable
     */
	 
	/*
    public function render($request, Throwable $exception)
    {
	    if($exception instanceof ValidationException){
		    $errors = $exception->errors();
		    $messages = [];
		    foreach($errors as $error){
			    array_push($messages, $error[0]['message']);
		    }
		    return $this->validationErrors($messages);
	    }
	    if($exception instanceof ModelNotFoundException){
		    $this->errorLogRecord($exception);
		    $message = ['en' => 'Does not exists any model with specified identificator', 'ar' => 'لا يوجد أي نموذج مع معرف محدد'];
		    //return $this->errorResponse(DOES_NOT_EXISTS_ANY_MODEL_WITH_SPECIFIED_IDENTIFICATOR);
		    return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
	    }
	    if($exception instanceof BadMethodCallException){
		    $this->errorLogRecord($exception);
		    //return $this->errorResponse(DOES_NOT_EXISTS_SPECIFIED_URL);
		    //$message = ['en' => 'Does not exists specified URL', 'ar' => 'لا يوجد عنوان URL محدد'];
		    $message = ['en' => $exception->getMessage(), 'ar' => 'لا يوجد عنوان URL محدد'];
		    return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
	    }
	    if($exception instanceof NotFoundHttpException){
		    $this->errorLogRecord($exception);
		    //return $this->errorResponse(DOES_NOT_EXISTS_SPECIFIED_URL);
		    $message = ['en' => 'Does not exists specified URL', 'ar' => 'لا يوجد عنوان URL محدد'];
		    return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
	    }
	    if($exception instanceof MethodNotAllowedHttpException){
		    $this->errorLogRecord($exception);
		    //return $this->errorResponse(SPECIFIED_METHOD_FOR_THE_REQUEST_IS_INVALID);
		    $message = ['en' => 'Specified method for the request is invalid', 'ar' => "الطريقة المحددة للطلب غير صالحة"];
		    return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
	    }
	    if($exception instanceof HttpException){
		    $this->errorLogRecord($exception);
		    //return $this->errorResponse(SOMETHING_WENT_WRONG);
		    $message = ['en' => 'Something went wrong', 'ar' => 'خطـأ في العملية'];
		    return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
	    }
	    if($exception instanceof NotWritableException){
		    $this->errorLogRecord($exception);
		    //return $this->errorResponse(YOU_ARE_NOT_PROVIDED_ANY_IMAGE);
		    $message = ['en' => 'You are not provided any image', 'ar' => 'لم يتم تقديم أي صورة لك'];
		    return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
	    }
	    if($exception instanceof QueryException){
		    $this->errorLogRecord($exception);
		    //return $this->errorResponse(UNEXPECTED_EXCEPTION_PLEASE_TRY_LATER);
		    $message = ['en' => 'Unexpected Exception Please try later', 'ar' => 'استثناء غير متوقع يرجى المحاولة في وقت لاحق'];
		    return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
	    }
	    // if($exception instanceof FatalThrowableError){
		    // $this->errorLogRecord($exception);
		    return $this->errorResponse(UNEXPECTED_EXCEPTION_PLEASE_TRY_LATER);
		    // $message = ['en' => 'Unexpected Exception Please try later', 'ar' => 'استثناء غير متوقع يرجى المحاولة في وقت لاحق'];
		    // return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
	    // }
	    if($exception instanceof PDOException){
		    $this->errorLogRecord($exception);
		    //return $this->errorResponse(UNEXPECTED_EXCEPTION_PLEASE_TRY_LATER);
		    $message = ['en' => 'Unexpected PDO Exception Please try later', 'ar' => 'استثناء PDO غير متوقع يرجى المحاولة في وقت لاحق'];
		    return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
	    }
	    if($exception instanceof ErrorException){
		    $this->errorLogRecord($exception);
		    //return $this->errorResponse(UNEXPECTED_EXCEPTION_PLEASE_TRY_LATER);
		    $message = ['en' => 'Unexpected Exception Please try later', 'ar' => 'استثناء غير متوقع يرجى المحاولة في وقت لاحق'];
		    return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
	    }
        if($exception instanceof CustomException){
            $this->errorLogRecord($exception);
            $message = ['en' => $exception->jsonMessage['message']['lang']['en'], 'ar' => $exception->jsonMessage['message']['lang']['ar']];
            return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
        }
        if($exception instanceof DynamicException){
            $this->errorLogRecord($exception);
            $message = ['en' => $exception->jsonMessage['message']['lang']['en'] . ' ' . $exception->param, 'ar' => $exception->jsonMessage['message']['lang']['ar'] . ' ' . $exception->param];
            return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
        }
	    if(config('app.debug')){
		    $this->errorLogRecord($exception);
		    return parent::render($request, $exception);
	    }
	    //return $this->errorResponse(UNEXPECTED_EXCEPTION_PLEASE_TRY_LATER);
	    $this->errorLogRecord($exception);
	    $message = ['en' => 'Unexpected Exception Please try later', 'ar' => 'استثناء غير متوقع يرجى المحاولة في وقت لاحق'];
	    return response()->json(['error' => ['message' => [$message]], 'code' => 422], 422);
		
    }
	*/

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
