<?php

namespace App\Traits\Models;


/**
 * Trait CustomMethods
 * @package App\Traits\Models
 */
trait CustomMethods
{
	/**
	 * @param $request
	 * @param $model
	 *
	 * @return mixed
	 */
	public function updateLoop($request, $model)
	{
		foreach ($request as $key => $value){
			$model->$key = $value;
		}
		return $model;
	}
}