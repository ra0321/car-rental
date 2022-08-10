<?php

namespace App\Traits;

use App\Exceptions\CustomException;
use Carbon\Carbon;

/**
 * Trait DateVerification
 * @package App\Traits
 */
trait DateVerification
{

    /**
     * @param $request
     * @throws CustomException
     */
    public function checkDate($request)
	{
		$check = checkdate($request->monthOB, $request->dayOB, $request->yearOB);
		if(!$check){
            throw new CustomException(THIS_IS_NOT_VALID_DATE);
		}
	}

	/**
	 * @param $request
	 *
	 * @return string
	 */
	public function createDate($request)
	{
		$date = Carbon::create($request->yearOB, $request->monthOB, $request->dayOB)->toDateString();
		$dob = Carbon::parse($date)->format('Y-m-d');
		return $dob;
	}

    /**
     * @param $startDate
     * @param $endDate
     * @return bool
     * @throws CustomException
     */
    public function compareDates($startDate, $endDate)
	{
		$firstDate = Carbon::parse($startDate);
		$secDate = Carbon::parse($endDate);
		$compare = $firstDate->lt($secDate);

		if(!$compare){
            throw new CustomException(START_DATE_IS_BIGGER_OR_EQUAL_WITH_FINISH_DATE);
		}
		return true;
	}

    /**
     * @param $request
     * @throws CustomException
     */
    public function checkDateFromArray($request)
	{
		$check = checkdate($request['monthOB'], $request['dayOB'], $request['yearOB']);
		if(!$check){
            throw new CustomException(THIS_IS_NOT_VALID_DATE);
		}
	}

	/**
	 * @param $request
	 *
	 * @return string
	 */
	public function createDateFromArray($request)
	{
		$date = Carbon::create($request['yearOB'], $request['monthOB'], $request['dayOB'])->toDateString();
		$dob = Carbon::parse($date)->format('Y-m-d');
		return $dob;
	}
}