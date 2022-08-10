<?php

namespace App\Traits\SocialNetworks;

use App\Events\Activity\WelcomeUserEvent;
use App\Events\User\CreateUser;
use App\Profile;
use App\Social;
use App\User;
use Carbon\Carbon;
use DB;
use Exception;
use Illuminate\Support\Str;
use Log;

/**
 * Trait FacebookLoginTrait
 * @package App\Traits\SocialNetworks
 */
trait FacebookLoginTrait
{
    /**
     * @param $data
     * @return array
     */
    private function facebookLoginUser($data)
    {
        if($data['facebookUser']){
            if($data['isWithId']){
                $result = $this->loginFacebookUser($data);
            }else{
                $result = $this->updateFacebookUser($data);
            }
        }else{
            $result = $this->registerFacebookUser($data);
        }
        return $result;
    }

    /**
     * @param $data
     * @return array
     */
    private function registerFacebookUser($data)
    {
        $result = ['status' => 200, 'message' => '', 'data' => ''];
        $user = new User();
        $getUser = User::where('email', $data['request']->email)->first();
        $password = bcrypt($data['request']->social_id . $data['request']->only('email')['email']);
        $user['first_name'] = $data['request']->only('first_name')['first_name'];
        $user['last_name'] = $data['request']->only('last_name')['last_name'];
        $user['email'] = $data['request']->only('email')['email'];
        $user['email_promotions'] = $data['request']->only('email_promotions')['email_promotions'];
        $user['is_facebook'] = $data['request']->only('is_facebook')['is_facebook'];
        $user['is_google'] = $data['request']->only('is_google')['is_google'];
        $user['password'] = $password;
        $user['verify_email_token'] = Str::random(40);
        try{
            DB::beginTransaction();
                if (!$getUser) {
                    $user->save();
                    event(new CreateUser($user));
                    event(new WelcomeUserEvent($user));
                }

                $social = new Social;
                $getSocial = Social::where('email', $user->email)->first();
                $social['social_id'] = $data['request']->social_id;
                $social['first_name'] = $user->first_name;
                $social['last_name'] = $user->last_name;
                $social['email'] = $user->email;
                $social['picture_url'] = $data['request']->only('picture_url')['picture_url'];
                $social['password'] = $password;
                $social['user_id'] = $getUser ? $getUser->id : $user->id;

                $profile = new Profile([
                    'user_id' => $getUser ? $getUser->id : $user->id,
                ]);

                if(!$getSocial) {
                    $social->save();
                    $profile->save();
                }

                $result['data'] = $social;

            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            Log::alert($e->getMessage(), ['exception' => $e]);
            return ['status' => 400, 'message' => 'App cant save user', 'data' => ''];
        }
        return $result;
    }

    /**
     * @param $data
     * @return array
     */
    private function loginFacebookUser($data)
    {
        $result = ['status' => 200, 'message' => '', 'data' => ''];
        if(!$this->checkAppToken($data)){
            return ['status' => 400, 'message' => 'App id is not correct', 'data' => ''];
        }
        $data['facebookUser']->last_time_login = Carbon::now()->toDateTimeString();
        try{
            $data['facebookUser']->save();
            $result['data'] = $data['facebookUser'];
        }catch(Exception $e){
            Log::alert($e->getMessage(), ['exception' => $e]);
            return ['status' => 400, 'message' => 'App cant save user', 'data' => ''];
        }
        return $result;
    }

    /**
     * @param $data
     * @return array
     */
    private function updateFacebookUser($data)
    {
        $result = ['status' => 200, 'message' => '', 'data' => ''];
        if(!$this->checkAppToken($data)){
            return ['status' => 400, 'message' => 'App id is not correct', 'data' => ''];
        }
        $data['facebookUser']->social_id = $data['request']->social_id;
        $data['facebookUser']->last_time_login = Carbon::now()->toDateTimeString();
        $user = User::findOrFail($data['facebookUser']->user_id);
        $user->password = bcrypt($data['facebookUser']->social_id . $data['facebookUser']->email);
        try{
            $data['facebookUser']->save();
            $user->save();
            $result['data'] = $data['facebookUser'];
        }catch(Exception $e){
            Log::alert($e->getMessage(), ['exception' => $e]);
            return ['status' => 400, 'message' => 'App cant save user', 'data' => ''];
        }
        return $result;
    }
}