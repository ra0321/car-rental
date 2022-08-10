<?php

namespace App\Log;

use App\Log\Formatter\JsonFormatter;

/**
 * Class JsonLogger
 * @package App\Log
 */
class JsonLogger {
	/**
	 * @param $logger
	 */
	public function __invoke($logger)
	{
		foreach ($logger->getHandlers() as $handler) {
			$handler->setFormatter(new JsonFormatter());
		}
	}
}
