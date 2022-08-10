<?php
namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;

/**
 * Class CustomException
 * @package App\Exceptions
 */
class CustomException extends Exception
{
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json(
        	[
        		'error' => [
        			'message' => [$this->jsonMessage['message']['lang']]
		        ],
		        'code' => $this->jsonMessage['http_code']
	        ],
	        $this->jsonMessage['http_code']
        );
    }
}
