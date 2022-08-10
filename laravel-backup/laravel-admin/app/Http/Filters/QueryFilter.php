<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Requests\Search\SearchCarRules;

/**
 * Class QueryFilter
 * @package App\Http\Filters
 */
abstract class QueryFilter
{
	/**
	 * @var SearchCarRules
	 */
	protected $request;

	/**
	 * @var
	 */
	protected $builder;

    /**
     * QueryFilter constructor.
     * @param $request
     */
    public function __construct(SearchCarRules $request)
    {
        $this->request = $request;
    }

	/**
	 * @param Builder $builder
	 *
	 * @return Builder
	 */
	public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach($this->filters() as $name => $value){
            if(method_exists($this, $name)){
                call_user_func_array([$this, $name], array_filter([$value]));
            }
        }

        return $this->builder;
    }

	/**
	 * @return array
	 */
	public function filters()
    {
        return $this->request->all();
    }

}