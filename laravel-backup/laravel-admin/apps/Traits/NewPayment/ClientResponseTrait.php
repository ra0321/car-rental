<?php

namespace App\Traits\NewPayment;

use App\Exceptions\CustomException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use Log;
use Psr\Http\Message\ResponseInterface;

trait ClientResponseTrait
{
    /**
     * @param $params
     *
     * @return ResponseInterface
     */
    public function clientResponse($params)
    {
        $client = new Client();
        return $client->post('https://secure.telr.com/gateway/order.json', [
            'headers' => [
                'Content-type' => 'application/x-www-form-urlencoded'
            ],
            'form_params' => $params
        ]);
    }

    /**
     * @param $params
     *
     * @return mixed|ResponseInterface
     * @throws GuzzleException
     */
    public function remoteXml($params)
    {
        $client = new Client();
        $headers = ['Content-type' => 'text/xml; charset=UTF8'];
        $request = new GuzzleRequest('POST','https://secure.telr.com/gateway/remote.xml', $headers, $params);
        return $client->send($request);
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
        $auth = base64_encode(config('values.telr_id') . ':' . config('values.telr_key'));
        $client = new Client();
        $clientResponse = $client->get($address, [
            'headers' => [
                'Authorization' => 'Basic ' . $auth
            ]
        ]);
        return $this->clientResponseParseToJson($clientResponse);
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
        return $this->clientResponseParseToJson($clientResponse);
    }

    /**
     * @param $clientResponse
     *
     * @return mixed
     * @throws CustomException
     */
    public function paymentParse(ResponseInterface $clientResponse)
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
    private function clientResponseParseToJson(ResponseInterface $clientResponse)
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
     * @throws CustomException
     */
    private function getResponseBody(ResponseInterface $clientResponse)
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
        return json_decode($jsonParse, TRUE);
    }
}