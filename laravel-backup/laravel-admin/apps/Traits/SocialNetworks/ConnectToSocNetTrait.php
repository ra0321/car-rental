<?php

namespace App\Traits\SocialNetworks;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Log;

/**
 * Trait ConnectToSocNetTrait
 * @package App\Traits\SocialNetworks
 */
trait ConnectToSocNetTrait
{

    /**
     * @param $request
     * @return array|mixed
     * @throws GuzzleException
     */
    private function getUserData($request)
    {
        if ($request->is_google === 'false') {
            $is_google = $request->is_google == 'false' ? false: false;
        } elseif ($request->google === 'true') {
            $is_google = $request->is_google == 'true' ? true : true;
        } else {
            $is_google = $request->is_google;
        }


        if($is_google){
            $userData = $this->getDataFromGoogleToken($request->only('accessToken'));
        }else{
            $userData = $this->getDataFromFacebookToken($request);
        }
        return $userData;
    }
    /**
     * @param $token
     * @return mixed
     * @throws GuzzleException
     */
    private function getDataFromGoogleToken($token)
    {
        $client = new Client([
            'base_uri' => 'https://oauth2.googleapis.com',
        ]);

        try{
            $appResponse = $client->request("GET", "/tokeninfo", [
                'query' => [
                    'id_token' => $token['accessToken']
                ]
            ]);
            return json_decode($appResponse->getBody(), true);
        }catch(Exception $e){
            Log::alert($e->getMessage(), ['exception' => $e]);
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $request
     * @return array
     * @throws GuzzleException
     */
    private function getDataFromFacebookToken($request)
    {
        $token = $request->only('accessToken');
        $facebookTokens = [];
        $client = new Client([
            'base_uri' => 'https://graph.facebook.com',
        ]);
        $facebookTokens['esarAppToken'] = $this->getEsarFacebookAppToken();
        $facebookTokens['esarWebToken'] = $this->getEsarWebFacebookAppToken();
        $facebookTokens['esarFirstToken'] = $this->getEsarFirstFacebookAppToken();

        $allFbData = [];

        foreach($facebookTokens as $k => $fbToken){
            try{
                $clientResponse = $client->request("GET", "/debug_token", [
                    'query' => [
                        'input_token' => $token['accessToken'],
                        'access_token' => $fbToken['access_token']
                    ]
                ]);
                $allFbData[$k] = json_decode($clientResponse->getBody(), true);
                break;
            }catch(Exception $e){
                continue;
            }
        }


        return $allFbData;
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function getEsarFacebookAppToken()
    {
        #####################################################
        #       THIS IS METHOD FOR LIVE FACEBOOK APP        #
        #####################################################
        $client = new Client([
            'base_uri' => 'https://graph.facebook.com',
        ]);
        try{
            $appResponse = $client->request("GET", "/oauth/access_token", [
                'query' => [
                    'client_id' => config('values.esar_facebook_app_client_id'),
                    'client_secret' => config('values.esar_facebook_app_client_secret'),
                    'grant_type' => 'client_credentials'
                ]
            ]);
            return json_decode($appResponse->getBody(), true);
        }catch(Exception $e){
            Log::alert($e->getMessage(), ['exception' => $e]);
            //throw new Exception($e->getMessage());
        }
    }

    /**
     * @return mixed
     * @throws GuzzleException
     */
    public function getEsarWebFacebookAppToken()
    {
        ####################################################
        #       THIS IS METHOD FOR WEB FACEBOOK APP        #
        ####################################################
        #   THIS METHOD SHOULD BE DELETED AFTER 6 MONTHS   #
        ####################################################
        $client = new Client([
            'base_uri' => 'https://graph.facebook.com',
        ]);
        try{
            $appResponse = $client->request("GET", "/oauth/access_token", [
                'query' => [
                    'client_id' => config('values.esar_web_facebook_app_client_id'),
                    'client_secret' => config('values.esar_web_facebook_app_client_secret'),
                    'grant_type' => 'client_credentials'
                ]
            ]);
            return json_decode($appResponse->getBody(), true);
        }catch(Exception $e){
            Log::alert($e->getMessage(), ['exception' => $e]);
            //throw new Exception($e->getMessage());
        }
    }

    /**0
     * @return mixed
     * @throws GuzzleException
     */
    public function getEsarFirstFacebookAppToken()
    {
        ######################################################
        #       THIS IS METHOD FOR FIRST FACEBOOK APP        #
        ######################################################
        #    THIS METHOD SHOULD BE DELETED AFTER 6 MONTHS    #
        ######################################################
        $client = new Client([
            'base_uri' => 'https://graph.facebook.com',
        ]);
        try{
            $appResponse = $client->request("GET", "/oauth/access_token", [
                'query' => [
                    'client_id' => config('values.esar_first_facebook_app_client_id'),
                    'client_secret' => config('values.esar_first_facebook_app_client_secret'),
                    'grant_type' => 'client_credentials'
                ]
            ]);
            return json_decode($appResponse->getBody(), true);
        }catch(Exception $e){
            Log::alert($e->getMessage(), ['exception' => $e]);
            //throw new \Exception($e->getMessage());
        }
    }
}