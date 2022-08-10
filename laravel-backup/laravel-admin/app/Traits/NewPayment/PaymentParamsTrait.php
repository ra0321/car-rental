<?php

namespace App\Traits\NewPayment;

use App\TripBill;
use App\User;

/**
 * Trait PaymentParamsTrait
 * @package App\Traits\NewPayment
 */
trait PaymentParamsTrait
{
    /**
     * @param $params
     * @param $trip_bill
     *
     * @return mixed
     */
    private static function dynamicParams($params, $trip_bill)
    {
        $request = Request();
        $lang = $request->header('Lang') == 'en' ? $request->header('Lang') : 'ar';
        $url = config('values.app_url');
        $params['ivp_test'] = '1';
        $params['ivp_lang'] = $lang;
        $params['return_auth'] = 'http://localhost:4212/' . $lang . '/payment/success';
        $params['return_can'] = 'http://localhost:4212/' . $lang . '/payment/cancel';
        $params['return_decl'] = 'http://localhost:4212/' . $lang . '/payment/route';
        if($url === 'http://esar.apis'){
            $params['ivp_cart'] = $trip_bill->id . '_127';
        }else if ($url === 'http://esar.home'){
            $params['ivp_cart'] = $trip_bill->id . '_128';
        }else if($url === 'http://dev.esarcar.com'){
            $params['ivp_cart'] = $trip_bill->id;
            $params['return_auth'] = 'http://dev.esarcar.com/' . $lang . '/payment/success';
            $params['return_can'] = 'http://dev.esarcar.com/' . $lang . '/payment/cancel';
            $params['return_decl'] = 'http://dev.esarcar.com/' . $lang . '/payment/route';
        }else if ($url === 'https://www.esarcar.com'){
            $params['ivp_cart'] = $trip_bill->id;
            $params['ivp_test'] = '0';
            $params['return_auth'] = 'https://www.esarcar.com/' . $lang . '/payment/success';
            $params['return_can'] = 'https://www.esarcar.com/' . $lang . '/payment/cancel';
            $params['return_decl'] = 'https://www.esarcar.com/' . $lang . '/payment/route';
        }
        return $params;
    }

    /**
     * @param TripBill $trip_bill
     * @param User $user
     * @return array|mixed
     */
    public function payTrip(TripBill $trip_bill, User $user)
    {
        $idCard = $user->idCard->last();
        $params = array(
            'ivp_method' => 'create',
            'ivp_store' => config('values.telr_store_id'),
            'ivp_authkey' => config('values.telr_store_auth_key'),
            'ivp_trantype' => 'sale',
            'ivp_tranclass ' => 'ecom',
            'ivp_currency' => 'SAR',
            'ivp_amount' => $trip_bill->trip_total,
            'ivp_desc' => $trip_bill->booked_instantly ? 'Booked Instantly' : 'Trip Request',
            'bill_email' => $user->email,
            'bill_fname' => $user->first_name,
            'bill_sname' => $user->last_name,
            'bill_city' => $idCard ? $idCard->id_city : '',
            'bill_country' => $idCard ? $idCard->id_country : '',
        );
        $params = self::dynamicParams($params, $trip_bill);
        return $params;
    }

    /**
     * @param TripBill $trip_bill
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
     * @return string
     */
    public function refundWithFirstPenalty(TripBill $trip_bill)
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
    }

    /**
     * @param TripBill $trip_bill
     * @return string
     */
    public function refundWithSecondPenalty(TripBill $trip_bill)
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
    }

    /**
     * @param TripBill $trip_bill
     * @return string
     */
    public function voidPreviousTransaction(TripBill $trip_bill)
    {
        $store_id = config('values.telr_store_id');
        $store_key = config('values.telr_remote_key');
        $amount = $trip_bill->refund_amount;
        $params = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<remote>
  <store>$store_id</store>
  <key>$store_key</key>
  <tran>
    <type>void</type>
    <class>ecom</class>
	<description>Void Transaction</description>
    <currency>SAR</currency>
    <amount>$amount</amount>
    <ref>$trip_bill->tran_ref</ref>
    <test>1</test>
  </tran>
</remote>
EOT;
        return $params;
    }

    /**
     * @param TripBill $trip_bill
     * @return string
     */
    public function refundLessOneDay(TripBill $trip_bill)
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
    }

    /**
     * @param TripBill $trip_bill
     * @return string
     */
    public function refundLessOneDay2ndVersion(TripBill $trip_bill)
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
    }
}