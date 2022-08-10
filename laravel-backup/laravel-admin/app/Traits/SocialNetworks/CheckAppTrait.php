<?php

namespace App\Traits\SocialNetworks;

use Log;

trait CheckAppTrait
{
    private function checkAppToken($data)
    {

        if($data['request']->app_id !== config('values.esar_facebook_app_client_id')){
            $line = __LINE__;
            $trait_name = __TRAIT__;
            Log::critical('App id is not correct', ['EXCEPTION' => ['class_name' => $trait_name, 'line' => $line]]);
            return false;
        }else{
            return true;
        }
    }
}