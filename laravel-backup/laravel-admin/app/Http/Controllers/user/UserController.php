<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangeEmailRules;
use App\Http\Requests\Auth\RegistrationRules;
use App\User;
use App\Profile;
use Illuminate\Support\Str;
use App\Events\User\CreateUser;
use App\Events\Activity\WelcomeUserEvent;
use App\Exceptions\CustomException;
use DB;
use Exception;
use App\Helpers\EsarPushNotifications;

class UserController extends Controller
{
    //
	
	public function registration(RegistrationRules $request)
	{
		$user = new User([
			'first_name' => $request['first_name'],
			'last_name' => $request['last_name'],
			'email' => $request['email'],
			'password' => bcrypt($request['password']),
			'verify_email_token' => Str::random(40),
			'email_promotions' => $request['email_promotions'],
		]);

		try{
		    DB::beginTransaction();
            $user->save();
            // Refresh user after save to get all data from DB
            $user = User::findOrFail($user->id);
            DB::commit();
        }catch(Exception $e){
		    DB::rollBack();
		    Log::alert($e->getMessage(), ['exception' => $e]);
            return $this->errorResponse(SOMETHING_WENT_WRONG);
        }

        $credentials = request()->only('email', 'password');
        $user->token = $this->tokenValue($credentials);
        $profile = new Profile();
        $profile->user_id = $user->id;

        event(new CreateUser($user));
        event(new WelcomeUserEvent($user));
        EsarPushnotifications::newUser($user);

        try{
            DB::beginTransaction();
            $profile->save();
            DB::commit();
            return $this->showOne($user, 201);
        }catch(Exception $e){
            DB::rollBack();
            Log::alert($e->getMessage(), ['exception' => $e]);
            return $this->errorResponse(SOMETHING_WENT_WRONG);
        }
	}
}
