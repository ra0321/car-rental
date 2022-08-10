<?php

namespace App\Http\Controllers;

use App\User;
use App\Car;
use App\Trip;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource as UserResource;
use App\Http\Resources\UsersResource as UsersResource;
use App\Http\Resources\CarsResource as CarsResource;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\TripBills;

class UsersController extends Controller
{
    public function getUser($id)
    {
        $user = User::with('profile', 'car')->find($id);
    	return new UserResource($user);
    }

    public function getUsers(Request $request)
    {
        $active = ($request->get('active') != null) ? $request->get('active') : '';
        $verified = ($request->get('verified') != null) ? $request->get('verified') : '';
        $search = ($request->get('search') != null) ? $request->get('search') : '';
        $date_range = ($request->get('dates') != null) ? explode(',', $request->get('dates')) : [];
        $rowsPerPage = ($request->rowsPerPage) ? $request->rowsPerPage : 10;
        if($active != ""){
            // dd($active);
            if ($search == ""  && empty($date_range)) {
                // dd(User::where('user_active_status', $active)->count());
                $users = User::ActiveInActiveUsers($active)
                    ->whereHas('profile')
                    ->paginate($rowsPerPage);
            } else {
                // dd($date_range);
                $users = User::ActiveInActiveUsers($active)->SearchId($search)
                    ->SearchFirstName($search)
                    ->SearchLastName($search)
                    ->SearchEmail($search)
                    ->SearchPhone($search)
                    ->SearchDateRange($date_range)
                    ->whereHas('profile')
                    ->orderBy('id', 'ASC')
                    ->paginate($rowsPerPage);
            }
        }
        else if($verified != ""){
            // dd($verified);
            if ($search == ""  && empty($date_range)) {
                // dd(User::where('approved_to_drive', $verified)
                //     ->VerifiedUser($verified)->count());
                $users = User::VerifiedUnverifiedUsers($verified)
                    ->paginate($rowsPerPage);
            } else {
                $users = User::VerifiedUnverifiedUsers($verified)
                    ->SearchFirstName($search)
                    ->SearchLastName($search)
                    ->SearchEmail($search)
                    ->SearchPhone($search)
                    ->SearchDateRange($date_range)
                    ->orderBy('id', 'ASC')
                    ->paginate($rowsPerPage);
            }
        }
        else
        {
            if ($search == "" && empty($date_range)) {
                $users = User::whereHas('profile')->paginate($rowsPerPage);
            } 
            else
            {
                $users = User::SearchId($search)
                        ->SearchFirstName($search)
                        ->SearchLastName($search)
                        ->SearchEmail($search)
                        ->SearchPhone($search)
                        ->SearchDateRange($date_range)
                        ->orderBy('id', 'ASC')
                        ->paginate($rowsPerPage);
            }
        }
    	return new UsersResource($users);
    }


    public function getUsersExport(Request $request)
    {
        $active = ($request->get('active') != null) ? $request->get('active') : '';
        $verified = ($request->get('verified') != null) ? $request->get('verified') : '';
        $search = ($request->get('search') != null) ? $request->get('search') : '';
        $date_range = ($request->get('dates') != null) ? explode(',', $request->get('dates')) : [];
        $rowsPerPage = ($request->rowsPerPage) ? $request->rowsPerPage : 10;
        if($active != ""){
            // dd($active);
            if ($search == ""  && empty($date_range)) {
                // dd(User::where('user_active_status', $active)->count());
                $users = User::ActiveInActiveUsers($active)
                    ->whereHas('profile')
                    ->get();
            } else {
                // dd($date_range);
                $users = User::ActiveInActiveUsers($active)->SearchId($search)
                    ->SearchFirstName($search)
                    ->SearchLastName($search)
                    ->SearchEmail($search)
                    ->SearchPhone($search)
                    ->SearchDateRange($date_range)
                    ->whereHas('profile')
                    ->orderBy('id', 'ASC')
                    ->get();
            }
        }
        else if($verified != ""){
            // dd($verified);
            if ($search == ""  && empty($date_range)) {
                // dd(User::where('approved_to_drive', $verified)
                //     ->VerifiedUser($verified)->count());
                $users = User::VerifiedUnverifiedUsers($verified)
                    ->get();
            } else {
                $users = User::VerifiedUnverifiedUsers($verified)
                    ->SearchFirstName($search)
                    ->SearchLastName($search)
                    ->SearchEmail($search)
                    ->SearchPhone($search)
                    ->SearchDateRange($date_range)
                    ->orderBy('id', 'ASC')
                    ->get();
            }
        }
        else
        {
            if ($search == "" && empty($date_range)) {
                $users = User::whereHas('profile')->get();
            } 
            else
            {
                $users = User::SearchId($search)
                        ->SearchFirstName($search)
                        ->SearchLastName($search)
                        ->SearchEmail($search)
                        ->SearchPhone($search)
                        ->SearchDateRange($date_range)
                        ->orderBy('id', 'ASC')
                        ->get();
            }
        }
    	return new UsersResource($users);
    }

    public function getUserDashboard(Request $request)
    {
        if($request->has('model')){
            $model = $request->get('model');
            $status = $request->get('status');
            $type = $request->get('type');
            if($model == "Car"){

                if($type == "verified"){
                    $active = Car::where('is_insurance_verified', $status)
                            ->where('is_registration_car_verified', $status)
                            ->whereHas('user')
                            ->count();
                    $daily = Car::where('is_insurance_verified', $status)
                            ->where('is_registration_car_verified', $status)
                            ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
                    $weekly = Car::where('is_insurance_verified', $status)
                            ->where('is_registration_car_verified', $status)
                            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    $monthly = Car::where('is_insurance_verified', $status)
                            ->where('is_registration_car_verified', $status)
                            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                    $yearly = Car::where('is_insurance_verified', $status)
                            ->where('is_registration_car_verified', $status)
                            ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
                
                }else if($type == "active"){
                    $active = Car::where('car_is_active', $status)
                            ->whereHas('user')
                            ->count();
                    $daily = Car::where('car_is_active', $status)
                            ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
                    $weekly = Car::where('car_is_active', $status)
                            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    $monthly = Car::where('car_is_active', $status)
                            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                    $yearly = Car::where('car_is_active', $status)
                            ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
                }
            }else if($model == "Trip"){
                
                if($type == "confirmed"){
                    // dd([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')]);
                    $active = Trip::Confirmed()->count();
                    $daily = Trip::Confirmed()->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::Confirmed()->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::Confirmed()->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::Confirmed()->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                
                }
                else if ($type == "cancelled") {
                    $active = Trip::Cancelled()->count();
                    $daily = Trip::Cancelled()->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::Cancelled()->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::Cancelled()->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::Cancelled()->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                
                }
                else if ($type == "finished") {
                    $active = Trip::Finished()->count();
                    $daily = Trip::Finished()->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::Finished()->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::Finished()->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::Finished()->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                
                }
                else if ($type == "waiting") {
                    $active = Trip::Waiting()->count();
                    $daily = Trip::Waiting()->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::Waiting()->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::Waiting()->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::Waiting()->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                
                }
            }
            else if($model == "User"){
                if($type == "active"){
                    $active = User::ActiveInActiveUsers($status)->count();
                    $daily = User::ActiveInActiveUsers($status)->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
                    $weekly = User::ActiveInActiveUsers($status)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    $monthly = User::ActiveInActiveUsers($status)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                    $yearly = User::ActiveInActiveUsers($status)->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
                }else if ($type == "verified") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    $active = User::VerifiedUnverifiedUsers($status)->count();
                    $daily = User::VerifiedUnverifiedUsers($status)->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
                    $weekly = User::VerifiedUnverifiedUsers($status)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    $monthly = User::VerifiedUnverifiedUsers($status)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                    $yearly = User::VerifiedUnverifiedUsers($status)->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
                }
            }
            
            $data = ['active'=>$active, 'daily'=> $daily, 'weekly'=> $weekly, 'monthly'=> $monthly, 'yearly'=> $yearly];
            
        }
        else{
            $active = User::where('user_active_status', true)->whereHas('profile')->count();
            $daily = User::whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
            $weekly = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $monthly = User::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $yearly = User::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
            
            $data = ['active'=>$active, 'daily'=> $daily, 'weekly'=> $weekly, 'monthly'=> $monthly, 'yearly'=> $yearly];
            
        }
        return response()->json($data);
    }

    public function getUsersFavoriteCars($id)
    {
    	$cars = DB::table('favorite_cars')->where('user_id', $id)->get();
    	$favorites = $cars->flatMap(function ($car){
    		return Car::where('id', $car->car_id)->get();
    	});

    	return new CarsResource($favorites);
    }

    public function getUsersRecentlyViewedCars($id)
    {
    	$cars = DB::table('recently_viewed_cars')->where('user_id', $id)->get();
    	$viewed = $cars->flatMap(function ($car){
    		return Car::where('id', $car->car_id)->get();
    	});

    	return new CarsResource($viewed);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->update([
            'user_active_status' => false,
            'admin_delete' => true,
            'deleting_time' => Carbon::now()->toDateTimeString()
        ]);

        $user->car->each(function ($item){
            $item->update([
                'car_is_active' => false,
                'is_deleted' => true
            ]);

            DB::table('car_unlisteds')->where('car_id', $item->id)->insert([
                'car_id' => $item->id,
                'car_status' => 'deleted',
                'admin_delete' => true,
                'user_auto_delete' => true
            ]);
        });

        return response()->json(['User is deleted'], 200);
    }

    public function restoreUser($id)
    {
        $user = User::find($id);
        $user->update([
            'user_active_status' => true,
            'admin_delete' => false,
			'deleting_time' => null
        ]);

        return response()->json(['User is restored'], 200);
    }

   public function approveId($id)
    {
        $user = User::find($id);
        $user->update([
            'id_verified' => true
        ]);

        return response()->json(['ID approved'], 200);
    }

   public function approveLicence($id)
    {
        $user = User::find($id);
        $user->update([
            'approved_to_drive' => true
        ]);

        return response()->json(['Drivers licence approved'], 200);
    }

   public function denyId($id)
    {
        $user = User::find($id);
        $user->update([
            'id_verified' => false
        ]);

        return response()->json(['ID denied'], 200);
    }

   public function denyLicence($id)
    {
        $user = User::find($id);
        $user->update([
            'approved_to_drive' => false
        ]);

        return response()->json(['Drivers licence denied'], 200);
    }

    public function pay($id)
    {
		$tripBills = TripBills::where('trip_id', $id)->first();
		$trip = Trip::find($id);
        $tripBills->update(['esar_paid' => 1, 'esar_paid_date' => Carbon::now()]);
		$user = User::with('bills', 'owner')->find($trip->owner_id);
        return new UserResource($user);
    }
}
