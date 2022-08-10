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
 * Trait GoogleLoginTrait
 * @package App\Traits\SocialNetworks
 */
trait GoogleLoginTrait
{
    /**
     * @param $data
     * @return array
     */
    private function googleLoginUser($data)
    {
        $result = ['status' => 200, 'message' => '', 'data' => ''];
        if($data['googleUser']){
            $data['googleUser']->last_time_login = Carbon::now()->toDateTimeString();
            try{
                $data['googleUser']->save();
                $result['data'] = $data['googleUser'];
            }catch(Exception $e){
                Log::alert($e->getMessage(), ['exception' => $e]);
                return ['status' => 400, 'message' => 'App cant save user', 'data' => ''];
            }
        }else{
            $user = new User();
            $getUser = User::where('email', $data['userData']['email'])->first();
            $password = bcrypt($data['userData']['sub'] . $data['userData']['email']);
            $user['first_name'] = $data['userData']['given_name'];
            $user['last_name'] = $data['userData']['family_name'];
            $user['email'] = $data['userData']['email'];
            $user['email_promotions'] = $data['request']->only('email_promotions')['email_promotions'];
            $user['is_facebook'] = $data['request']->only('is_facebook')['is_facebook'];
            $user['is_google'] = $data['request']->only('is_google')['is_google'];
            $user['password'] = $password;
            $user['verify_email_token'] = Str::random(40);
            try{
                DB::beginTransaction();
                    if(!$getUser) {
                        $user->save();
                        event(new CreateUser($user));
                        event(new WelcomeUserEvent($user));
                    }

                    $social = new Social;
                    $getSocial = Social::where('email', $data['userData']['email'])->first();

                    $social['social_id'] = $data['userData']['sub'];
                    $social['first_name'] = $data['userData']['given_name'];
                    $social['last_name'] = $data['userData']['family_name'];
                    $social['email'] = $data['userData']['email'];
                    $social['picture_url'] = $data['userData']['picture'];
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
        }
        return $result;
    }
}