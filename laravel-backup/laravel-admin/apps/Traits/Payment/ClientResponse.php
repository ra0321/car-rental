<?php

namespace App\Traits\Payment;

use App\Exceptions\CustomException;
use App\Traits\Errors\ErrorLogTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Log;

/**
 * Trait ClientResponse
 * @package App\Traits\Payment
 */
trait ClientResponse
{
	/**
	 * @param $params
	 *
	 * @return \Psr\Http\Message\ResponseInterface
	 */
	public function clientResponse($params)
	{
		$client = new Client();
		$response = $client->post('https://secure.telr.com/gateway/order.json', [
			'headers' => [
				'Content-type' => 'application/x-www-form-urlencoded'
			],
			'form_params' => $params
		]);

		return $response;
	}

	/**
	 * @param $params
	 *
	 * @return mixed|\Psr\Http\Message\ResponseInterface
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function remoteXml($params)
	{
		$client = new Client();
		$headers = ['Content-type' => 'text/xml; charset=UTF8'];
		$request = new GuzzleRequest('POST','https://secure.telr.com/gateway/remote.xml', $headers, $params);
		$response = $client->send($request);
		return $response;
	}

	/**
	 * @param $trip_bill
	 *
	 * @return mixed
	 * @throws CustomException
	 */
	public function checkTransaction($trip_bill)
	{
		$url = config('values.app_url');
		switch ($url){
            case 'http://esar.apis':
                $address = 'https://secure.telr.com/tools/api/xml/transaction/' . $trip_bill->id . '_127/cart';
                break;
            case 'http://esar.home':
                $address = 'https://secure.telr.com/tools/api/xml/transaction/' . $trip_bill->id . '_128/cart';
                break;
            default:
                $address = 'https://secure.telr.com/tools/api/xml/transaction/' . $trip_bill->id . '/cart';
                break;
        }
		/*if($url === 'http://esar.apis'){
			$address = 'https://secure.telr.com/tools/api/xml/transaction/' . $trip_bill->id . '_127/cart';
		}else if($url = 'tvoj'){
            $address = 'https://secure.telr.com/tools/api/xml/transaction/' . $trip_bill->id . '_128/cart';
        }else if($url === 'http://dev.esarcar.com'){
			$address = 'https://secure.telr.com/tools/api/xml/transaction/' . $trip_bill->id . '/cart';
		}else if ($url === 'https://www.esarcar.com'){
			$address = 'https://secure.telr.com/tools/api/xml/transaction/' . $trip_bill->id . '/cart';
		}*/
        $auth = base64_encode(config('values.telr_id') . ':' . config('values.telr_key'));
		$client = new Client();
		$clientResponse = $client->get($address, [
			'headers' => [
				'Authorization' => 'Basic ' . $auth
			]
		]);
		$clientJsonResponse = $this->clientResponseParseToJson($clientResponse);
		return $clientJsonResponse;
	}

    /**
     * @param $tran_ref
     * @return mixed
     * @throws CustomException
     */
    public function findTransactionByTranRef($tran_ref)
    {
        $address = "https://secure.innovatepayments.com/tools/api/xml/transaction/" . $tran_ref;
        $auth = base64_encode(config('values.telr_id') . ':' . config('values.telr_key'));
        $client = new Client();
        $clientResponse = $client->get($address, [
            'headers' => [
                'Authorization' => 'Basic ' . $auth
            ]
        ]);
        $clientJsonResponse = $this->clientResponseParseToJson($clientResponse);
        return $clientJsonResponse;
    }

	/**
	 * @param $clientResponse
	 *
	 * @return mixed
	 * @throws CustomException
	 */
	public function paymentParse($clientResponse)
	{
		$path = storage_path() . "/JSON/bankErrors.json";
		$bankError = json_decode(file_get_contents($path), true);

		if(json_decode($clientResponse->getStatusCode(), true) === 200){
			$xml = simplexml_load_string($clientResponse->getBody());
			$json = json_encode($xml);
			$jsonResponse = json_decode($json,TRUE);
			if($jsonResponse['auth']['status'] !== 'A'){
				$errorMessage = $bankError[$jsonResponse['auth']['code']];
				//$code = $jsonResponse['auth']['code'];
				// TODO 10 TESTIRATI
				Log::critical($errorMessage['message']['lang']['en']);
				throw new CustomException($errorMessage);
			}
		}else{
			throw new CustomException(SOMETHING_WENT_WRONG_WITH_PAYMENT);
		}

		return $jsonResponse;
	}

	/**
	 * @param $clientResponse
	 *
	 * @return mixed
	 * @throws CustomException
	 */
	private function clientResponseParseToJson($clientResponse)
	{
		if(json_decode($clientResponse->getStatusCode(), true) === 200){
			$xml = simplexml_load_string($clientResponse->getBody());
			$json = json_encode($xml);
			$array = json_decode($json,TRUE);
		}else{
			throw new CustomException(SOMETHING_WENT_WRONG_WITH_PAYMENT);
		}

		return $array;
	}

	/**
	 * @param $transDetail
	 *
	 * @throws CustomException
	 */
	private function isDuplicateTransaction($transDetail)
	{
		if($transDetail['trancount'] > 1){
            throw new CustomException(SORRY_THIS_IS_DUPLICATE_TRANSACTION);
        }
	}

	/**
	 * @param $clientResponse
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	private function getResponseBody($clientResponse)
	{
		if(json_decode($clientResponse->getStatusCode(), true) === 200){
			$responseBody = json_decode($clientResponse->getBody(), true);
			if(isset($responseBody['order']['ref'])){
				return $responseBody;
			}else{
				$error_message = 'MESSAGE: ' . $responseBody['error']['message'] . '; NOTE: ' . $responseBody['error']['note'] .'; DETAILS: ' . $responseBody['error']['details'];
				Log::critical($error_message);
				throw new CustomException(SOMETHING_WENT_WRONG_WITH_PAYMENT);
			}
		}else{
			throw new CustomException(SOMETHING_WENT_WRONG_WITH_PAYMENT);
		}
	}

    /**
     * @param $params
     * @return mixed
     */
    private function jsonParams($params)
	{
		$paramsXML = simplexml_load_string($params);
		$jsonParse = json_encode($paramsXML);
		$jsonParams = json_decode($jsonParse, TRUE);
		return $jsonParams;
	}
}
