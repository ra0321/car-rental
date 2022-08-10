<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\JsonResponse;

class PaymentException extends Exception {
	use ApiResponser;

	/**
	 * @var
	 */
	public $jsonMessage;

	/**
	 * CustomException constructor.
	 * @param $jsonMessage
	 */
	public function __construct($jsonMessage)
	{
		parent::__construct();
		$this->jsonMessage = $jsonMessage;
	}

	/**
	 * @return JsonResponse
	 */
	public function render()
	{
		return response()->json(
			[
				'error' => [
					'message' => [$this->jsonMessage['message']['lang']]
				],
				'code' => $this->jsonMessage['http_code'],
				'status' => $this->jsonMessage['status']
			],
			$this->jsonMessage['http_code']
		);
	}
}
