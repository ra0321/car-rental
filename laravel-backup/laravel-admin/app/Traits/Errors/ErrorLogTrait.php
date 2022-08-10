<?php

namespace App\Traits\Errors;

use App\ErrorLog;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Trait ErrorLogTrait
 * @package App\Traits\Errors
 */
trait ErrorLogTrait
{
    /**
     * @param $exception
     * @param int $user
     */
	public function errorLogRecord($exception, $user = 0)
	{
		$error_log = new ErrorLog();
		$message = $this->errorMessage($exception);

		$error_log->fill([
			'request_uri' => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null,
			'redirect_uri' => isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : null,
			'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null,
			'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null,
			'exception_trace' => method_exists($exception, 'getTraceAsString') ? $exception->getTraceAsString() : null,
			'exception_previous' => method_exists($exception, 'getPrevious') ? $exception->getPrevious() : null,
			'file' => method_exists($exception, 'getFile') ? $exception->getFile() : null,
			'line' => method_exists($exception, 'getLine') ? $exception->getLine() : null,
			'message' => isset($message) ? $message : null,
			'code' => method_exists($exception, 'getCode') ? $exception->getCode() : null,
			'severity' => method_exists($exception, 'getSeverity') ? $exception->getSeverity() : null,
			'model' => method_exists($exception, 'getModel') ? $exception->getModel() : null,
			'ids' => method_exists($exception, 'getIds') ? json_encode($exception->getIds()) : null,
			'status_code' => method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : null,
			'headers' => method_exists($exception, 'getHeaders') ? json_encode($exception->getHeaders()) : null,
			'error_info' => property_exists($exception, 'errorInfo') ? json_encode($exception->errorInfo) : null,
			'sql_error' => method_exists($exception, 'getSql') ? $exception->getSql() : null,
			'user_id' => isset($user) ? $user : null
		]);

		$error_log->save();
	}

	/**
	 * @param $exception
	 *
	 * @return mixed|string|null
	 */
	protected function errorMessage($exception)
	{
		$exceptionInstance = get_class($exception);
		$exceptionName = $this->getClassName($exceptionInstance);
		$customExceptions = ['CustomException', 'DynamicException', 'PaymentException'];
		switch ($exception){
			case($exception instanceof NotFoundHttpException):
				$message = method_exists($exception, 'getMessage') && $exception->getMessage() !== "" ? $exception->getMessage() : 'Does not exists specified URL.';
				break;
			case(in_array($exceptionName, $customExceptions)):
				$message = $exception->jsonMessage['message']['lang']['en'];
				break;
			default:
				$message = method_exists($exception, 'getMessage') ? $exception->getMessage() : null;
		}
		return $message;
	}

	/**
	 * @param $instance
	 *
	 * @return mixed
	 */
	protected function getClassName($instance)
	{
		$explode = explode('\\', $instance);
		$name = $explode[count($explode) - 1];
		return $name;
	}
}
