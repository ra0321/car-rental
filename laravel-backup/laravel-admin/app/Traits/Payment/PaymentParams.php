<?php

namespace App\Traits\Payment;

use App\Exceptions\CustomException;
use App\Trip;
use App\TripBill;
use App\User;
use http\Client\Request;

/**
 * Trait PaymentParams
 * @package App\Traits\Payment
 */
trait PaymentParams
{
    /**
	 * @param $params
	 * @param $trip_bill
	 *
	 * @return mixed
	 */
	/*private static function dynamicParams($params, $trip_bill)
	{
		$request = Request();
		$lang = $request->header('Lang') == 'en' ? $request->header('Lang') : 'ar';
		$url = config('values.app_url');
		if($url === 'http://esar.apis'){
			$params['ivp_cart'] = $trip_bill->id . '_127';
			$params['ivp_test'] = '1';
			$params['ivp_lang'] = $lang;
			$params['return_auth'] = 'http://localhost:4212/' . $lang . '/payment/success';
			$params['return_can'] = 'http://localhost:4212/' . $lang . '/payment/cancel';
			$params['return_decl'] = 'http://localhost:4212/' . $lang . '/payment/route';
		}else if ($url === 'http://esar.home'){
            $params['ivp_cart'] = $trip_bill->id . '_128';
            $params['ivp_test'] = '1';
            $params['ivp_lang'] = $lang;
            $params['return_auth'] = 'http://localhost:4212/' . $lang . '/payment/success';
            $params['return_can'] = 'http://localhost:4212/' . $lang . '/payment/cancel';
            $params['return_decl'] = 'http://localhost:4212/' . $lang . '/payment/route';
        }else if($url === 'http://dev.esarcar.com'){
			$params['ivp_cart'] = $trip_bill->id;
			$params['ivp_test'] = '1';
			$params['ivp_lang'] = $lang;
			$params['return_auth'] = 'http://dev.esarcar.com/' . $lang . '/payment/success';
			$params['return_can'] = 'http://dev.esarcar.com/' . $lang . '/payment/cancel';
			$params['return_decl'] = 'http://dev.esarcar.com/' . $lang . '/payment/route';
		}else if ($url === 'https://www.esarcar.com'){
			$params['ivp_cart'] = $trip_bill->id;
			$params['ivp_test'] = '0';
			$params['ivp_lang'] = $lang;
			$params['return_auth'] = 'https://www.esarcar.com/' . $lang . '/payment/success';
			$params['return_can'] = 'https://www.esarcar.com/' . $lang . '/payment/cancel';
			$params['return_decl'] = 'https://www.esarcar.com/' . $lang . '/payment/route';
		}
		return $params;
	}*/

	/**
	 * @param Trip $trip
	 * @param TripBill $trip_bill
	 * @param User $user
	 *
	 * @return array
	 * @throws CustomException
	 */
	/*public function bookedInstantly(Trip $trip, TripBill $trip_bill, User $user)
	{
		//$this->checkDocuments($user);
		$params = array(
			'ivp_method' => 'create',
			'ivp_store' => config('values.telr_store_id'),
			'ivp_authkey' => env('TELR_STORE_AUTH_KEY'),
			'ivp_trantype' => 'sale',
			'ivp_tranclass ' => 'ecom',
			'ivp_amount' => $trip_bill->trip_total,
			'ivp_currency' => 'SAR',
			'ivp_desc' => 'Booked Instantly',
			'bill_email' => $user->email,
			'bill_fname' => $user->first_name,
			'bill_sname' => $user->last_name,
			'bill_city' => $user->profile->id_city ? $user->profile->id_city : '',
			'bill_country' => $user->profile->id_country ? $user->profile->id_country : '',
		);
		$params = self::dynamicParams($params, $trip_bill);
		return $params;
	}*/

	/**
	 * @param Trip $trip
	 * @param TripBill $trip_bill
	 * @param User $user
	 *
	 * @return array
	 * @throws CustomException
	 */
	public function tripRequest(Trip $trip, TripBill $trip_bill, User $user)
	{
		//$this->checkDocuments($user);
		$params = array(
			'ivp_method' => 'create',
            'ivp_store' => config('values.telr_store_id'),
            'ivp_authkey' => config('values.telr_store_auth_key'),
			'ivp_trantype' => 'auth',
			'ivp_tranclass ' => 'ecom',
			'ivp_amount' => $trip_bill->trip_total,
			'ivp_currency' => 'SAR',
			'ivp_desc' => 'Pre Authorization',
			'bill_email' => $user->email,
			'bill_fname' => $user->first_name,
			'bill_sname' => $user->last_name,
			'bill_city' => $user->profile->id_city ? $user->profile->id_city : '',
			'bill_country' => $user->profile->id_country ? $user->profile->id_country : '',
            /*'ivp_store' => '20181',
            'ivp_authkey' => '5V3Ln-kgz2L~Pfvs',*/
		);
		$params = self::dynamicParams($params, $trip_bill);
		return $params;
	}

	/**
	 * @param Trip $trip
	 * @param TripBill $trip_bill
	 * @param User $user
	 *
	 * @return string
	 */
	public function capture(Trip $trip, TripBill $trip_bill, User $user)
	{
	    $store_id = config('values.telr_store_id');
	    $store_key = config('values.telr_remote_key');
$params = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<remote>
  <store>$store_id</store>
  <key>$store_key</key>
  <tran>
    <type>capture</type>
    <class>ecom</class>
	<description>Capture Transaction</description>
    <currency>SAR</currency>
    <amount>$trip_bill->trip_total</amount>
    <ref>$trip_bill->tran_ref</ref>
    <test>1</test>
  </tran>
</remote>
EOT;
		return $params;
	}

	/**
	 * @param TripBill $trip_bill
	 *
	 * @return string
	 */
	public function releaseWholeAmount(TripBill $trip_bill)
	{
        $store_id = config('values.telr_store_id');
        $store_key = config('values.telr_remote_key');
$params = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<remote>
  <store>$store_id</store>
  <key>$store_key</key>
  <tran>
    <type>release</type>
    <class>ecom</class>
	<description>Release Transaction</description>
    <currency>SAR</currency>
    <amount>$trip_bill->trip_total</amount>
    <ref>$trip_bill->tran_ref</ref>
    <test>1</test>
  </tran>
</remote>
EOT;
		return $params;
	}

	/**
	 * @param TripBill $trip_bill
	 *
	 * @return string
	 */
	public function refundWholeAmount(TripBill $trip_bill)
	{
        $store_id = config('values.telr_store_id');
        $store_key = config('values.telr_remote_key');
$params = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<remote>
  <store>$store_id</store>
  <key>$store_key</key>
  <tran>
    <type>refund</type>
    <class>ecom</class>
	<description>Refund Transaction</description>
    <currency>SAR</currency>
    <amount>$trip_bill->trip_total</amount>
    <ref>$trip_bill->tran_ref</ref>
    <test>1</test>
  </tran>
</remote>
EOT;
		return $params;
	}

	/**
	 * @param TripBill $trip_bill
	 * @param $oldBill
	 *
	 * @return string
	 */
	public function refundPartAmount(TripBill $trip_bill, $oldBill)
	{
        $store_id = config('values.telr_store_id');
        $store_key = config('values.telr_remote_key');
		$refund = $trip_bill->trip_total * -1;
$params = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<remote>
  <store>$store_id</store>
  <key>$store_key</key>
  <tran>
    <type>refund</type>
    <class>ecom</class>
	<description>Refund Transaction</description>
    <currency>SAR</currency>
    <amount>$refund</amount>
    <ref>$oldBill->tran_ref</ref>
    <test>1</test>
  </tran>
</remote>
EOT;
		return $params;
	}

	/**
	 * @param TripBill $trip_bill
	 *
	 * @return string
	 */
	/*public function refundWithFirstPenalty(TripBill $trip_bill)
	{
        $store_id = config('values.telr_store_id');
        $store_key = config('values.telr_remote_key');
		$refund = floor($trip_bill->trip_total * 0.9);
$params = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<remote>
  <store>$store_id</store>
  <key>$store_key</key>
  <tran>
    <type>refund</type>
    <class>ecom</class>
	<description>Refund Transaction</description>
    <currency>SAR</currency>
    <amount>$refund</amount>
    <ref>$trip_bill->tran_ref</ref>
    <test>1</test>
  </tran>
</remote>
EOT;
		return $params;
	}*/

	/**
	 * @param TripBill $trip_bill
	 *
	 * @return string
	 */
	/*public function refundWithSecondPenalty(TripBill $trip_bill)
	{
        $store_id = config('values.telr_store_id');
        $store_key = config('values.telr_remote_key');
		$refund = floor($trip_bill->trip_total * 0.85);
$params = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<remote>
  <store>$store_id</store>
  <key>$store_key</key>
  <tran>
    <type>refund</type>
    <class>ecom</class>
	<description>Refund Transaction</description>
    <currency>SAR</currency>
    <amount>$refund</amount>
    <ref>$trip_bill->tran_ref</ref>
    <test>1</test>
  </tran>
</remote>
EOT;
		return $params;
	}*/

	/**
	 * @param TripBill $trip_bill
	 *
	 * @return string
	 */
	/*public function refundLessOneDay(TripBill $trip_bill)
	{
        $store_id = config('values.telr_store_id');
        $store_key = config('values.telr_remote_key');
		$refund = floor($trip_bill->trip_total * 0.85);
		$totalRefund = $refund - $trip_bill->average_price;
$params = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<remote>
  <store>$store_id</store>
  <key>$store_key</key>
  <tran>
    <type>refund</type>
    <class>ecom</class>
	<description>Refund Transaction</description>
    <currency>SAR</currency>
    <amount>$totalRefund</amount>
    <ref>$trip_bill->tran_ref</ref>
    <test>1</test>
  </tran>
</remote>
EOT;
		return $params;
	}*/

	/**
	 * @param TripBill $trip_bill
	 *
	 * @return string
	 */
	/*public function refundLessOneDay2ndVersion(TripBill $trip_bill)
	{
        $store_id = config('values.telr_store_id');
        $store_key = config('values.telr_remote_key');
		$halfDayPrice = floor($trip_bill->average_price / 2);
		$refund = floor($trip_bill->trip_total * 0.85);
		$totalRefund = $refund - $halfDayPrice;
$params = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<remote>
  <store>$store_id</store>
  <key>$store_key</key>
  <tran>
    <type>refund</type>
    <class>ecom</class>
	<description>Refund Transaction</description>
    <currency>SAR</currency>
    <amount>$totalRefund</amount>
    <ref>$trip_bill->tran_ref</ref>
    <test>1</test>
  </tran>
</remote>
EOT;
		return $params;
	}*/

	/**
	 * @param User $user
	 *
	 * @throws CustomException
	 */
	private function checkDocuments(User $user)
	{
		//if($user->profile->id_number === null){
        if($user->profile->expiration_date === null){
			throw new CustomException(WE_DONT_HAVE_DATA_OF_YOUR_ID);
		}
		//if($user->profile->driver_licence_number === null){
		if($user->profile->driver_licence_expiration_date === null){
			throw new CustomException(WE_DONT_HAVE_DATA_OF_YOUR_DRIVER_LICENCE);
		}
	}
}
