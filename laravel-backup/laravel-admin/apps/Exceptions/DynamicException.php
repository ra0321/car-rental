<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;

/**
 * Class DynamicException
 * @package App\Exceptions
 */
class DynamicException extends Exception
{
    use ApiResponser;

	/**
	 * @var
	 */
	public $jsonMessage;
	/**
	 * @var
	 */
	public $param;

	/**
	 * DynamicException constructor.
	 *
	 * @param $jsonMessage
	 * @param $param
	 */
	public function __construct($jsonMessage, $param)
    {
	    parent::__construct();
	    $this->jsonMessage = $jsonMessage;
	    $this->param = $param;
    }

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function render()
    {
    	$message = [];
    	$message['en'] = $this->jsonMessage['message']['lang']['en'] . ' ' . $this->param;
    	$message['ar'] = $this->jsonMessage['message']['lang']['ar'] . ' ' . $this->param;
	    return response()->json(['error' => ['message' => [$message]], 'code' => $this->jsonMessage['http_code']], $this->jsonMessage['http_code']);
    }
}
