<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

/**
 * Trait ApiResponser
 * @package App\Traits
 */
trait ApiResponser
{
	/**
	 * @param $data
	 * @param $code
	 *
	 * @return JsonResponse
	 */
	private function successResponse($data, $code)
	{
		return response()->json($data, $code);
	}

	/**
	 * @param     $jsonMessage
	 *
	 * @return JsonResponse
	 */
	protected function successResponseWithMessage($jsonMessage)
	{
		return response()->json(['success' => ['message' => [$jsonMessage['message']['lang']]], 'code' => $jsonMessage['http_code']], $jsonMessage['http_code']);
	}

	/**
	 * @param $jsonMessage
	 *
	 * @return JsonResponse
	 */
	protected function errorResponse($jsonMessage)
	{
		return response()->json(['error' => ['message' => [$jsonMessage['message']['lang']]], 'code' => $jsonMessage['http_code']], $jsonMessage['http_code']);
	}

	/**
	 * @param $messages
	 *
	 * @return JsonResponse
	 */
	protected function validationErrors($messages)
	{
		$allMessages = [];
		foreach ($messages as $message){
			$errorMessage = [];
			if(isset($message['params'])){
				switch($message['params']){
					case isset($message['params']['days']):
						$now = Carbon::now();
						$param = $now->addDays($message['params']['days'])->format('Y-m-d');
						foreach($message['lang'] as $key => $name){
							$errorMessage[$key] = $message['lang'][$key] . ' ' . $param;
						}
						array_push($allMessages, $errorMessage);
						break;
					case isset($message['params']['period']):
						$param = 100 * $message['params']['period'];
						foreach($message['lang'] as $key => $name){
							$errorMessage[$key] = $message['lang'][$key] . ' ' . $param;
						}
						array_push($allMessages, $errorMessage);
						break;
				}
			}else{
				foreach($message['lang'] as $key => $name){
					$errorMessage[$key] = $message['lang'][$key];
				}
				array_push($allMessages, $errorMessage);
			}
		}
		return response()->json(['error' => ['message' => $allMessages], 'code' => 422], 422);
	}

	/**
	 * @param Collection $collection
	 * @param int        $code
	 *
	 * @return JsonResponse
	 */
	protected function showAll(Collection $collection, $code = 200)
	{
		if($collection->isEmpty()){
			return $this->successResponse([
			    'data' => $collection,
                'meta' => [
                    'countItems' => count($collection)
                ]
            ], $code);
		}

		$transformer = $collection->first()->transformer;
		$collection = $this->transformDataCollections($collection, $transformer);

		return $this->successResponse($collection, $code);
	}

	/**
	 * @param Model $model
	 * @param int   $code
	 *
	 * @return JsonResponse
	 */
	protected function showOne(Model $model, $code = 200)
	{
		$transformer = $model->transformer;
		$model = $this->transformData($model, $transformer);
		return $this->successResponse($model, $code);
	}

    /**
     * @param $paginator
     * @param $transformer
     * @param int $code
     * @return JsonResponse
     */
    protected function showWithPagination($paginator, $transformer, $code = 200)
    {
        $data = $paginator->getCollection();
        $result = fractal()
            ->collection($data, $transformer)
            ->paginateWith(new IlluminatePaginatorAdapter($paginator))
            ->toArray();
        return $this->successResponse($result, $code);
    }

    /**
     * @param Collection $data
     * @param $transformer
     * @param int $code
     * @return JsonResponse
     */
    protected function showAllCustomTransformer(Collection $data, $transformer, $code = 200)
    {
        if($data->isEmpty()){
            return $this->successResponse([
                'data' => $data,
                'meta' => [
                    'countItems' => count($data)
                ]
            ], $code);
        }
        $result = fractal()->collection($data, new $transformer);
        return $this->successResponse($result, $code);
    }

	/**
	 * @param $data
	 * @param $transformer
	 *
	 * @return array
	 */
	protected function transformData($data, $transformer)
	{
		$transformation = fractal($data, new $transformer);
		return $transformation->toArray();
	}

    /**
     * @param $data
     * @param $transformer
     * @return array
     */
    protected function transformDataCollections($data, $transformer)
    {
        $transformation = fractal($data, new $transformer)->addMeta([
            'countItems' => count($data),
        ]);
        return $transformation->toArray();
    }
}