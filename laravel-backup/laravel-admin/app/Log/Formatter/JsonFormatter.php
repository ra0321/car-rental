<?php

namespace App\Log\Formatter;

use DateTimeZone;
use Monolog\Formatter\JsonFormatter as BaseFormatter;

/**
 * Class JsonFormatter
 * @package App\Log\Formatter
 */
class JsonFormatter extends BaseFormatter {

	/**
	 * @param array $record
	 *
	 * @return array|mixed|string
	 */
	public function format( array $record ) : string
	{
        if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === 'OPTIONS'){
            exit();
        }
		$request = request()->all();
		$headers = request()->headers;
		if(!empty($headers->get('timezone'))){
			$record['datetime']->setTimezone(new DateTimeZone($headers->get('timezone')));
		}
		if(isset($record['context']['user'])){
			$record = self::getUser($record);
		}
		if(isset($record['context']['exception'])){
			$exceptionInstance = get_class($record['context']['exception']);
			$exceptionName = $this->getClassName($exceptionInstance);
			$customExceptions = ['CustomException', 'DynamicException', 'PaymentException'];
			if(in_array($exceptionName, $customExceptions)){
				$jsonMessage = $record['context']['exception']->jsonMessage;
				$record['CUSTOM_EXCEPTION'] = [
					'Message' => $jsonMessage['message']['lang']['en'],
					'File' => $record['context']['exception']->getFile(),
					'Line' => $record['context']['exception']->getLine(),
				];
			}else{
				$record['EXCEPTION'] = [
					'File' => $record['context']['exception']->getFile(),
					'Line' => $record['context']['exception']->getLine(),
                    'Message' => $record['context']['exception']->getMessage(),
				];
			}
		}

        if(isset($record['context']['EXCEPTION'])){
            $record['EXCEPTION'] = [
                'File' => $record['context']['EXCEPTION']['class_name'],
                'Line' => $record['context']['EXCEPTION']['line'],
                'Message' => $record['message'],
            ];
        }

		$record = [
			'ID' => md5(rand(0, 9999999)),
			'LEVEL' => $record['level_name'],
			'REQUEST_URI' => isset($_SERVER["REQUEST_URI"]) ? $_SERVER["REQUEST_URI"] : null,
			'REQUEST_METHOD' => isset($_SERVER["REQUEST_METHOD"]) ? $_SERVER["REQUEST_METHOD"] : null,
			'MESSAGE' => $record['message'],
			'EXCEPTION_INSTANCE' => isset($exceptionName) ? $exceptionName : null,
			'EXCEPTION' => isset($record['EXCEPTION']) ? $record['EXCEPTION'] : null,
			'CUSTOM_EXCEPTION' => isset($record['CUSTOM_EXCEPTION']) ? $record['CUSTOM_EXCEPTION'] : null,
			'PAYLOAD' => [
				'header' => isset($headers) ? $headers->all() : null,
				'body' => isset($request) ? $request : null,
			],
			'RESPONSE' => isset($record['context']['response']) ? json_decode($record['context']['response'], true) : null,
            'TRANSACTION_DETAILS' => isset($record['context']['transaction_details']) ? json_decode($record['context']['transaction_details'], true) : null,
			'TIME' => $record['datetime']->format('Y-m-d H:i:s'),
			'HOST' => request()->server('SERVER_ADDR'),
			'REMOTE-ADDRESS' => request()->server('REMOTE_ADDR'),
			'SPEED' => round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 4) . 'sec'
		];
        return $this->toJson($this->normalize($record), true) . ($this->appendNewline ? "\n" : '');
	}

	/**
	 * @param array $record
	 *
	 * @return array
	 */
	private static function getUser(array $record)
	{
		$user = $record['context']['user'];
		$record = [
			'user' => [
				'id' => $user ? $user->id : null,
				'first name' => $user ? $user->first_name : null,
				'last name' => $user ? $user->last_name : null,
				'email' => $user ? $user->email : null,
			]
		];
		return $record;
	}

	private function getClassName($instance)
	{
		$explode = explode('\\', $instance);
		$name = $explode[count($explode) - 1];
		return $name;
	}
}
