<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Car;
use App\Trip;
use Carbon\Carbon;
use App\Http\Resources\UserResource as UserResource;
use App\Http\Resources\UsersResource as UsersResource;
use App\Http\Resources\CarResource as CarResource;
use App\Http\Resources\CarsResource as CarsResource;
use App\Http\Resources\TripResource as TripResource;
use App\Http\Resources\TripsResource as TripsResource;
use DB;
class ReportsController extends Controller
{
    public function sum()
    {
				
        $users = User::ActiveInActiveUsers(1)->count();

        $usersInactive = User::ActiveInActiveUsers(0)->count();
        
        $listedCar = Car::ProspectListed(1)->count();
        $prospectCars = Car::ProspectListed(0)->count();
        $verifiedCars = Car::VerifiedUnverified(1)
                ->count();
        $unverifiedCars = Car::VerifiedUnverified(0)
                ->count();
				
		$validCar = Car::Valid(1)->count();
		$expiredCar = Car::Valid(0)->count();
        
        $verifiedUsers = User::VerifiedUnverifiedUsers(1)->count();

        $unverifiedUsers = User::VerifiedUnverifiedUsers(0)->count();

        
        $trips = Trip::Confirmed()->count();
        $pending_trips = Trip::Pending()->count();
        $canceledTrips = Trip::Cancelled()->count();
        $finishedTrips = Trip::Finished()->count();

        $started_trips = Trip::Started()->count();
        $waitingTrips = Trip::Waiting()->count();
        $unfinishedTrips = Trip::Unfinished()->count();

        $lastDay = Trip::where('created_at', '>=', Carbon::now()->subDay())->where('renter_confirm_trip', 'confirmed')->where('owner_confirm_trip', 'confirmed')->count();
        $lastMonth = Trip::where('created_at', '>=', Carbon::now()->subMonth())->where('renter_confirm_trip', 'confirmed')->where('owner_confirm_trip', 'confirmed')->count();
        $owners = Car::where('car_is_active', true)->get()->unique('user_id')->count();
        
        $AllUsers = User::count();
        $AllCars = Car::count();
        $AllTrips = Trip::count();
		
		$cars_list = Car::select(DB::raw("MONTH(created_at) as months"), DB::raw("YEAR(created_at) as year") , DB::raw("(COUNT(id)) as Count"))
                        ->orderBy(DB::raw("MONTH(created_at)"))
                        ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("YEAR(created_at)"))
                        ->get();
						
		$users_list = User::select(DB::raw("MONTH(created_at) as months"), DB::raw("YEAR(created_at) as year") , DB::raw("(COUNT(id)) as Count"))
                        ->orderBy(DB::raw("MONTH(created_at)"))
						->groupBy(DB::raw("MONTH(created_at)"), DB::raw("YEAR(created_at)"))
                        ->get();
		// $trips_list = Trip::select(DB::raw("MONTH(created_at) as months"), DB::raw("YEAR(created_at) as year") , DB::raw("(COUNT(id)) as Count"))
                        // ->orderBy(DB::raw("MONTH(created_at)"))
						// ->groupBy(DB::raw("MONTH(created_at)"), DB::raw("YEAR(created_at)"))
                        // ->get();
						
        $response = collect([
			'users_list' => $users_list,
			'cars_list' => $cars_list,
            'allusers' => $AllUsers,
            'allcars' => $AllCars,
            'alltrips' => $AllTrips,
            'users' => $users, 
            'usersInactive' => $usersInactive, 
            'listedCar' => $listedCar, 
            'prospectCars' => $prospectCars,  
            'trips' => $trips, 
            'canceled_trips' => $canceledTrips, 
            'finished_trips' => $finishedTrips, 
            'pending_trips' => $pending_trips, 
            'started_trips' => $started_trips, 
            'waiting_trips' => $waitingTrips, 
            'unfinished_trips' => $unfinishedTrips, 
            'last_day' => $lastDay, 
            'last_month' => $lastMonth, 
            'owners' => $owners, 
            'unverified_cars' => $unverifiedCars, 
            'unverified_users' => $unverifiedUsers,
            'verified_cars' => $verifiedCars, 
            'verified_users' => $verifiedUsers,
			
			'valid_car' => $validCar, 
            'expired_car' => $expiredCar
        ]);
        return response()->json($response, 200);
    }


    public function getCounts(Request $request)
    {
        // dd($request->get('type'));
        if($request->has('model')){
            $model = $request->get('model');
            $status = $request->get('status');
            $type = $request->get('type');
            if($model == "Car"){

                if($type == "verified"){
                    $active = Car::VerifiedUnverified($status)->count();
                    $daily = Car::VerifiedUnverified($status)
                            ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
                    $weekly = Car::VerifiedUnverified($status)
                            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    $monthly = Car::VerifiedUnverified($status)
                            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                    $yearly = Car::VerifiedUnverified($status)
                            ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
                    $total = Car::all()->count();
                }
				if($type == "expired"){
                    $active = Car::Valid($status)->count();
                    $daily = Car::Valid($status)
                            ->whereBetween('cars.created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
                    $weekly = Car::Valid($status)
                            ->whereBetween('cars.created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    $monthly = Car::Valid($status)
                            ->whereBetween('cars.created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                    $yearly = Car::Valid($status)
                            ->whereBetween('cars.created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
                    $total = Car::all()->count();
                }
				else if($type == "active"){
                    $active = Car::ProspectListed($status)->count();
                    $daily = Car::ProspectListed($status)
                            ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
                    $weekly = Car::ProspectListed($status)
                            ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    $monthly = Car::ProspectListed($status)
                            ->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                    $yearly = Car::ProspectListed($status)
                            ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
                    $total = Car::all()->count();
                }else if($type == "allcars"){
                    $active = Car::count();
                    $daily = Car::whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
                    $weekly = Car::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    $monthly = Car::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                    $yearly = Car::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
                    $total = Car::all()->count();
                }
            }else if($model == "Trip"){
                
                if($type == "confirmed"){
                    // dd([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')]);
                    $active = Trip::Confirmed()->count();
                    $daily = Trip::Confirmed()->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::Confirmed()->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::Confirmed()->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::Confirmed()->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                    $total = Trip::all()->count();
                }
                else if ($type == "cancelled") {
                    $active = Trip::Cancelled()->count();
                    $daily = Trip::Cancelled()->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::Cancelled()->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::Cancelled()->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::Cancelled()->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                    $total = Trip::all()->count();
                }
                else if ($type == "finished") {
                    $active = Trip::Finished()->count();
                    $daily = Trip::Finished()->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::Finished()->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::Finished()->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::Finished()->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                    $total = Trip::all()->count();
                }
                else if ($type == "waiting") {
                    $active = Trip::Waiting()->count();
                    $daily = Trip::Waiting()->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::Waiting()->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::Waiting()->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::Waiting()->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                    $total = Trip::all()->count();
                }
                else if ($type == "started") {
                    $active = Trip::Started()->count();
                    $daily = Trip::Started()->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::Started()->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::Started()->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::Started()->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                    $total = Trip::all()->count();
                }
                else if ($type == "pending") {
                    $active = Trip::Pending()->count();
                    $daily = Trip::Pending()->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::Pending()->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::Pending()->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::Pending()->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                    $total = Trip::all()->count();
                }
                else if ($type == "unfinished") {
                    $active = Trip::Unfinished()->count();
                    $daily = Trip::Unfinished()->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::Unfinished()->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::Unfinished()->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::Unfinished()->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                    $total = Trip::all()->count();
                }
                else if ($type == "alltrips") {
                    $active = Trip::count();
                    $daily = Trip::SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->count();
                    $weekly = Trip::SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->count();
                    $monthly = Trip::SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->count();
                    $yearly = Trip::SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->count();
                    $total = Trip::all()->count();
                }
            }
            else if($model == "User"){
                if($type == "active"){
                    $active = User::ActiveInActiveUsers($status)->count();
                    $daily = User::ActiveInActiveUsers($status)->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
                    $weekly = User::ActiveInActiveUsers($status)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    $monthly = User::ActiveInActiveUsers($status)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                    $yearly = User::ActiveInActiveUsers($status)->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
                    $total = User::all()->count();
                    
                }else if ($type == "verified") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    $active = User::VerifiedUnverifiedUsers($status)->count();
                    $daily = User::VerifiedUnverifiedUsers($status)->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
                    $weekly = User::VerifiedUnverifiedUsers($status)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    $monthly = User::VerifiedUnverifiedUsers($status)->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                    $yearly = User::VerifiedUnverifiedUsers($status)->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
                    $total = User::all()->count();
                }
                else if ($type == "allusers") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    $active = User::count();
                    $daily = User::whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
                    $weekly = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
                    $monthly = User::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
                    $yearly = User::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
                    $total = User::all()->count();
                }
            }
            
            $data = [
                ['text' => 'Active' , 'value'=> $active, 'status' => $status, 'model' => $model, 'type' => $type], 
                ['text' => 'Daily' , 'value'=> $daily, 'status' => $status, 'model' => $model, 'type' => $type], 
                ['text' => 'Weekly' , 'value'=> $weekly, 'status' => $status, 'model' => $model, 'type' => $type], 
                ['text' => 'Monthly' , 'value'=> $monthly, 'status' => $status, 'model' => $model, 'type' => $type], 
                ['text' => 'Yearly' , 'value'=> $yearly, 'status' => $status, 'model' => $model, 'type' => $type],
                ['text' => 'Total' , 'value'=> $total, 'status' => $status, 'model' => $model, 'type' => $type]
            ];
        }
        else{
            $active = User::where('user_active_status', true)->count();
            $daily = User::whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()])->count();
            $weekly = User::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
            $monthly = User::whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()])->count();
            $yearly = User::whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])->count();
            $total = User::all()->count();
            
            $data = [
                ['text' => 'Active' , 'value'=> $active, 'status' => 1, 'model' => 'User', 'type' => 'active'], 
                ['text' => 'Daily' , 'value'=> $daily, 'status' => 1, 'model' => 'User', 'type' => 'active'], 
                ['text' => 'Weekly' , 'value'=> $weekly, 'status' => 1, 'model' => 'User', 'type' => 'active'], 
                ['text' => 'Monthly' , 'value'=> $monthly, 'status' => 1, 'model' => 'User', 'type' => 'active'], 
                ['text' => 'Yearly' , 'value'=> $yearly, 'status' => 1, 'model' => 'User', 'type' => 'active'],
                ['text' => 'Total' , 'value'=> $total, 'status' => 1, 'model' => 'User', 'type' => 'active']
            ];
            
        }
        return response()->json($data);
    }

    public function getCountsRecords(Request $request)
    {
        // get model, record duration (weekly, daily) get status and category
        $search = ($request->get('search') != null) ? $request->get('search') : '';
        if($request->has('model')){
            $model = $request->get('model');
            $status = $request->get('status');
            $type = $request->get('type');
            $duration_type = $request->get('duration');
            // get all date variants
            $rowsPerPage = ($request->rowsPerPage) ? $request->rowsPerPage : 10;
            $search = ($request->get('search') != null) ? $request->get('search') : '';
            $dateVal = [];
            if($duration_type && $duration_type == 'Daily'){
                $dateVal = [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()];
            }else if($duration_type && $duration_type == 'Weekly'){
                $dateVal = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
            }
            else if($duration_type && $duration_type == 'Monthly'){
                $dateVal = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
            }
            else if($duration_type && $duration_type == 'Yearly'){
                $dateVal = [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()];
            }
            else{
                $dateVal = [];
            }
            // dd($dateVal);
            if($model == "User"){
                if($type == "active"){
                    
                    if($duration_type == "Active"){
                        $users = User::ActiveInActiveUsers($status)
                            ->SearchAll($search)
                            ->orderBy('id', 'ASC')
                            ->paginate($rowsPerPage);
                        
                    }else if($duration_type == "Total") {
                        $users = User::SearchAll($search)
                        ->orderBy('id', 'ASC')->paginate($rowsPerPage);
                    }
                    else{
                        // dd($dateVal);
                        $users = User::ActiveInActiveUsers($status)
                            ->whereBetween('created_at', $dateVal)
                            ->SearchAll($search)
                            ->orderBy('id', 'ASC')
                            ->paginate($rowsPerPage);
                    }
                }else if ($type == "verified") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    if($duration_type == "Active"){
                    $users = User::VerifiedUnverifiedUsers($status)
                        ->SearchAll($search)
                        ->orderBy('id', 'ASC')->paginate($rowsPerPage);
                    }
                    else if($duration_type == "Total") {
                        $users = User::SearchAll($search)->paginate($rowsPerPage);
                    }
                    else{
                        $users = User::VerifiedUnverifiedUsers($status)
                            ->SearchAll($search)
                            ->whereBetween('created_at', $dateVal)
                            ->paginate($rowsPerPage);
                    }
                }
                else if ($type == "allusers") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    if($duration_type == "Active"){
                    $users = User::SearchAll($search)
                        ->orderBy('id', 'ASC')->paginate($rowsPerPage);
                    }
                    else if($duration_type == "Total") {
                        $users = User::SearchAll($search)->paginate($rowsPerPage);
                    }
                    else{
                        $users = User::SearchAll($search)
                            ->whereBetween('created_at', $dateVal)
                            ->paginate($rowsPerPage);
                    }
                }
                // dd($users);
                return new UsersResource($users);
            }
            else if($model == "Car"){
                if($type == "active"){
                    if($duration_type == "Active"){
                        $cars = Car::ProspectListed($status)
                        ->FlexSearch($search)
                        ->with('user')->paginate($rowsPerPage);
                    }
                    else if($duration_type == "Total") {
                        $cars = Car::with('user')->paginate($rowsPerPage);
                    }
                    else{
                        $cars = Car::ProspectListed($status)
                            ->whereBetween('created_at', $dateVal)
                            ->FlexSearch($search)
                            ->with('user')
                            ->paginate($rowsPerPage);
                    }
                }else if ($type == "verified") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    if($duration_type == "Active"){
                        $cars = Car::VerifiedUnverified($status)
                        ->FlexSearch($search)
                        ->with('user')
                        ->paginate($rowsPerPage);
                    }
                    else if($duration_type == "Total") {
                        $cars = Car::with('user')->paginate($rowsPerPage);
                    }
                    else{
                        $cars = Car::VerifiedUnverified($status)
                            ->whereBetween('created_at', $dateVal)
                            ->FlexSearch($search)
                            ->with('user')
                            ->paginate($rowsPerPage);
                    }
                }
				else if ($type == "expired") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    if($duration_type == "Active"){
                        $cars = Car::Valid($status)
                        ->FlexSearch($search)
                        ->with('user')
                        ->paginate($rowsPerPage);
                    }
                    else if($duration_type == "Total") {
                        $cars = Car::with('user')->paginate($rowsPerPage);
                    }
                    else{
                        $cars = Car::Valid($status)
                            ->whereBetween('created_at', $dateVal)
                            ->FlexSearch($search)
                            ->with('user')
                            ->paginate($rowsPerPage);
                    }
                }
                else if ($type == "allcars") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    if($duration_type == "Active"){
                        $cars = Car::FlexSearch($search)
                        ->with('user')
                        ->paginate($rowsPerPage);
                    }
                    else if($duration_type == "Total") {
                        $cars = Car::with('user')->paginate($rowsPerPage);
                    }
                    else{
                    $cars = Car::whereBetween('created_at', $dateVal)
                        ->FlexSearch($search)
                        ->with('user')
                        ->paginate($rowsPerPage);
                    }
                }
                // dd($users);
                return new CarsResource($cars);
            }
            else if($model == "Trip"){
                if($type == "confirmed"){
                    if ($duration_type == "Active") {
                        $trips = Trip::Confirmed()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Daily") {
                        $trips = Trip::Confirmed()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Weekly") {
                        $trips = Trip::Confirmed()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Monthly") {
                        $trips = Trip::Confirmed()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Yearly") {
                        $trips = Trip::Confirmed()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Total") {
                        $trips = Trip::with('owner', 'renter')->SearchId($search)->SearchOwners($search)->SearchRenter($search)->paginate($rowsPerPage);
                    }
                }
                else if ($type == "cancelled") {
                    if ($duration_type == "Active") {
                        $trips = Trip::Cancelled()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Daily") {
                        $trips = Trip::Cancelled()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Weekly") {
                        $trips = Trip::Cancelled()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Monthly") {
                        $trips = Trip::Cancelled()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Yearly") {
                        $trips = Trip::Cancelled()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Total") {
                        $trips = Trip::with('owner', 'renter')->SearchId($search)->SearchOwners($search)->SearchRenter($search)->paginate($rowsPerPage);
                    }
                }
                else if ($type == "finished") {
                    if($duration_type == "Active") {
                        $trips = Trip::Finished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Daily") {
                        $trips = Trip::Finished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Weekly") {
                        $trips = Trip::Finished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Monthly") {
                        $trips = Trip::Finished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Yearly") {
                        $trips = Trip::Finished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Total") {
                        $trips = Trip::with('owner', 'renter')->SearchId($search)->SearchOwners($search)->SearchRenter($search)->paginate($rowsPerPage);
                    }
                }
                else if ($type == "waiting") {
                    if($duration_type == "Active") {
                        $trips = Trip::Waiting()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Daily") {
                        $trips = Trip::Waiting()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Weekly") {
                        $trips = Trip::Waiting()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Monthly") {
                        $trips = Trip::Waiting()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Yearly") {
                        $trips = Trip::Waiting()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Total") {
                        $trips = Trip::with('owner', 'renter')->SearchId($search)->SearchOwners($search)->SearchRenter($search)->paginate($rowsPerPage);
                    }
                }
                else if ($type == "started") {
                    if($duration_type == "Active") {
                        $trips = Trip::Started()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Daily") {
                        $trips = Trip::Started()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Weekly") {
                        $trips = Trip::Started()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Monthly") {
                        $trips = Trip::Started()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Yearly") {
                        $trips = Trip::Started()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Total") {
                        $trips = Trip::with('owner', 'renter')->SearchId($search)->SearchOwners($search)->SearchRenter($search)->paginate($rowsPerPage);
                    }
                }
                else if ($type == "pending") {
                    if($duration_type == "Active") {
                        $trips = Trip::Pending()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Daily") {
                        $trips = Trip::Pending()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Weekly") {
                        $trips = Trip::Pending()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Monthly") {
                        $trips = Trip::Pending()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Yearly") {
                        $trips = Trip::Pending()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Total") {
                        $trips = Trip::with('owner', 'renter')->SearchId($search)->SearchOwners($search)->SearchRenter($search)->paginate($rowsPerPage);
                    }
                }
                else if ($type == "unfinished") {
                    if($duration_type == "Active") {
                        $trips = Trip::Unfinished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Daily") {
                        $trips = Trip::Unfinished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Weekly") {
                        $trips = Trip::Unfinished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Monthly") {
                        $trips = Trip::Unfinished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Yearly") {
                        $trips = Trip::Unfinished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Total") {
                        $trips = Trip::with('owner', 'renter')->SearchId($search)->SearchOwners($search)->SearchRenter($search)->paginate($rowsPerPage);
                    }
                }
                if($type == "alltrips"){
                    if ($duration_type == "Active") {
                        $trips = Trip::SearchOwners($search)->SearchId($search)->SearchRenter($search)->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Daily") {
                        $trips = Trip::SearchOwners($search)->SearchId($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Weekly") {
                        $trips = Trip::SearchOwners($search)->SearchId($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Monthly") {
                        $trips = Trip::SearchOwners($search)->SearchId($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Yearly") {
                        $trips = Trip::SearchOwners($search)->SearchId($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->paginate($rowsPerPage);
                    }else if($duration_type == "Total") {
                        $trips = Trip::with('owner', 'renter')->SearchId($search)->SearchOwners($search)->SearchRenter($search)->paginate($rowsPerPage);
                    }
                }
                return new TripsResource($trips);
            }
        }
        else{

        }

    }

    public function SampleChunk(){
        $downloadableData = [];
        $data = User::ChunkData();
        
        dd($data);
    }

    public function getCountsRecordsExport(Request $request)
    {
        // dd($request->all());
        // get model, record duration (weekly, daily) get status and category
        $downloadableData = [];
        $search = ($request->get('search') != null) ? $request->get('search') : '';
        if($request->has('model')){
            $model = $request->get('model');
            $status = $request->get('status');
            $type = $request->get('type');
            $duration_type = $request->get('duration');
            $date_range = ($request->get('dates') != null && $request->get('dates') != 'undefined') ? explode(',', $request->get('dates')) : [];
        
            // get all date variants
            $rowsPerPage = ($request->rowsPerPage) ? $request->rowsPerPage : 10;
            $search = ($request->get('search') != null) ? $request->get('search') : '';
            $dateVal = [];
            if($duration_type && $duration_type == 'Daily'){
                $dateVal = [Carbon::now()->startOfDay(), Carbon::now()->endOfDay()];
            }else if($duration_type && $duration_type == 'Weekly'){
                $dateVal = [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()];
            }
            else if($duration_type && $duration_type == 'Monthly'){
                $dateVal = [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()];
            }
            else if($duration_type && $duration_type == 'Yearly'){
                $dateVal = [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()];
            }
            else{
                $dateVal = [];
            }
            // dd($dateVal);
            if($model == "User"){
                if($type == "active"){
                    
                    if($duration_type == "Active"){
                        $users = collect(User::ActiveInActiveUsers($status)
                            ->SearchAll($search)
                            ->SearchDateRange($date_range)
                            ->ChunkData());
                        
                    }else if($duration_type == "Total") {
                        $users = collect(User::SearchAll($search)
                        ->SearchDateRange($date_range)
                        ->ChunkData());
                    }
                    else{
                        // dd($dateVal);
                        $users = collect(User::ActiveInActiveUsers($status)
                            ->SearchDateRange($date_range)
                            ->SearchAll($search)->ChunkData());
                        
                    }
                }else if ($type == "verified") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    if($duration_type == "Active"){
                    $users = collect(User::VerifiedUnverifiedUsers($status)
                        ->SearchAll($search)->SearchDateRange($date_range)->ChunkData());
                    }
                    else if($duration_type == "Total") {
                        $users = collect(User::SearchAll($search)->SearchDateRange($date_range)->ChunkData());
                    }
                    else{
                        $users = collect(User::VerifiedUnverifiedUsers($status)
                            ->SearchAll($search)
                            ->SearchDateRange($date_range)
                            ->ChunkData());
                    }
                }
                else if ($type == "allusers") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    if($duration_type == "Active"){
                    $users = collect(User::SearchAll($search)->SearchDateRange($date_range)->ChunkData());
                    }
                    else if($duration_type == "Total") {
                        $users = collect(User::SearchAll($search)->SearchDateRange($date_range)->ChunkData());
                        // dd($users);
                    }
                    else{
                        $users = collect(User::SearchAll($search)
                            ->SearchDateRange($date_range)
                            ->ChunkData());
                    }
                }
                else{
                    $users = collect(User::SearchAll($search)
                            ->SearchDateRange($date_range)
                            ->ChunkData());
                }
                // dd($users);
                return new UsersResource($users);
            }
            else if($model == "Car"){
                if($type == "active"){
                    if($duration_type == "Active"){
                        $cars = collect(Car::ProspectListed($status)
                        ->FlexSearch($search)
                        ->with('user')->SearchDateRange($date_range)
                        ->ChunkData());
                    }
                    else if($duration_type == "Total") {
                        $cars = collect(Car::with('user')->FlexSearch($search)->SearchDateRange($date_range)
                        ->ChunkData());
                    }
                    else{
                        $cars = collect(Car::ProspectListed($status)
                            ->whereBetween('created_at', $dateVal)
                            ->FlexSearch($search)
                            ->with('user')
                            ->SearchDateRange($date_range)
                            ->ChunkData());
                    }
                }else if ($type == "verified") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    if($duration_type == "Active"){
                        $cars = collect(Car::VerifiedUnverified($status)
                        ->FlexSearch($search)
                        ->with('user')
                        ->SearchDateRange($date_range)
                        ->ChunkData());
                    }
                    else if($duration_type == "Total") {
                        $cars = collect(Car::with('user')->FlexSearch($search)->SearchDateRange($date_range)
                        ->ChunkData());
                    }
                    else{
                        $cars = collect(Car::VerifiedUnverified($status)
                            ->whereBetween('created_at', $dateVal)
                            ->FlexSearch($search)
                            ->with('user')
                            ->SearchDateRange($date_range)
                            ->ChunkData());
                    }
                }
				else if ($type == "expired") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    if($duration_type == "Active"){
                        $cars = collect(Car::Valid($status)
                        ->FlexSearch($search)
                        ->with('user')
                        ->SearchDateRange($date_range)
                        ->ChunkData());
                    }
                    else if($duration_type == "Total") {
                        $cars = collect(Car::with('user')->FlexSearch($search)->SearchDateRange($date_range)
                        ->ChunkData());
                    }
                    else{
                        $cars = collect(Car::Valid($status)
                            ->whereBetween('created_at', $dateVal)
                            ->FlexSearch($search)
                            ->with('user')
                            ->SearchDateRange($date_range)
                            ->ChunkData());
                    }
                }
                else if ($type == "allcars") {
                    // dd(User::where('approved_to_drive', $status)->orWhere('id_verified', $status)->count());
                    if($duration_type == "Active"){
                        $cars = collect(Car::FlexSearch($search)
                        ->with('user')
                        ->SearchDateRange($date_range)
                        ->ChunkData());
                    }
                    else if($duration_type == "Total") {
                        $cars = collect(Car::with('user')->FlexSearch($search)->SearchDateRange($date_range)
                        ->ChunkData());
                    }
                    else{
                    $cars = collect(Car::whereBetween('created_at', $dateVal)
                        ->FlexSearch($search)
                        ->with('user')
                        ->SearchDateRange($date_range)
                        ->ChunkData());
                    }
                }else{
                    $cars = collect(Car::FlexSearch($search)
                        ->with('user')
                        ->SearchDateRange($date_range)
                        ->ChunkData());
                }
                // dd($users);
                return new CarsResource($cars);
            }
            else if($model == "Trip"){
                if($type == "confirmed"){
                    if ($duration_type == "Active") {
                        $trips = collect(Trip::Confirmed()
                            ->SearchId($search)
                            ->SearchOwners($search)
                            ->SearchRenter($search)
                            ->SearchDateRange($date_range)
                            ->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Daily") {
                        $trips = collect(Trip::Confirmed()
                            ->SearchId($search)
                            ->SearchOwners($search)
                            ->SearchRenter($search)
                            ->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])
                            ->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Weekly") {
                        $trips = collect(Trip::Confirmed()
                            ->SearchId($search)
                            ->SearchOwners($search)
                            ->SearchRenter($search)
                            ->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])
                            ->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Monthly") {
                        $trips = collect(Trip::Confirmed()
                            ->SearchId($search)
                            ->SearchOwners($search)
                            ->SearchRenter($search)
                            ->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])
                            ->with('owner', 'renter')
                            ->ChunkData());
                    }else if($duration_type == "Yearly") {
                        $trips = collect(Trip::Confirmed()
                            ->SearchId($search)
                            ->SearchOwners($search)
                            ->SearchRenter($search)
                            ->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])
                            ->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Total") {
                        $trips = collect(Trip::with('owner', 'renter')
                            ->SearchId($search)
                            ->SearchOwners($search)
                            ->SearchRenter($search)->SearchDateRange($date_range)->ChunkData());
                    }
                }
                else if ($type == "cancelled") {
                    if ($duration_type == "Active") {
                        $trips = collect(Trip::Cancelled()
                            ->SearchId($search)
                            ->SearchOwners($search)
                            ->SearchRenter($search)->SearchDateRange($date_range)
                            ->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Daily") {
                        $trips = collect(Trip::Cancelled()
                            ->SearchId($search)
                            ->SearchOwners($search)
                            ->SearchRenter($search)
                            ->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])
                            ->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Weekly") {
                        $trips = collect(Trip::Cancelled()
                            ->SearchId($search)
                            ->SearchOwners($search)
                            ->SearchRenter($search)
                            ->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Monthly") {
                        $trips = collect(Trip::Cancelled()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Yearly") {
                        $trips = collect(Trip::Cancelled()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Total") {
                        $trips = collect(Trip::with('owner', 'renter')->SearchDateRange($date_range)->SearchId($search)->SearchOwners($search)->SearchRenter($search)->ChunkData());
                    }
                }
                else if ($type == "finished") {
                    if($duration_type == "Active") {
                        $trips = collect(Trip::Finished()->SearchDateRange($date_range)->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Daily") {
                        $trips = collect(Trip::Finished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Weekly") {
                        $trips = collect(Trip::Finished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Monthly") {
                        $trips = collect(Trip::Finished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Yearly") {
                        $trips = collect(Trip::Finished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Total") {
                        $trips = collect(Trip::with('owner', 'renter')->SearchDateRange($date_range)->SearchId($search)->SearchOwners($search)->SearchRenter($search)->ChunkData());
                    }
                }
                else if ($type == "waiting") {
                    if($duration_type == "Active") {
                        $trips = collect(Trip::Waiting()->SearchDateRange($date_range)->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Daily") {
                        $trips = collect(Trip::Waiting()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Weekly") {
                        $trips = collect(Trip::Waiting()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Monthly") {
                        $trips = collect(Trip::Waiting()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Yearly") {
                        $trips = collect(Trip::Waiting()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Total") {
                        $trips = collect(Trip::with('owner', 'renter')->SearchDateRange($date_range)->SearchId($search)->SearchOwners($search)->SearchRenter($search)->ChunkData());
                    }
                }
                else if ($type == "started") {
                    if($duration_type == "Active") {
                        $trips = collect(Trip::Started()->SearchDateRange($date_range)->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Daily") {
                        $trips = collect(Trip::Started()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Weekly") {
                        $trips = collect(Trip::Started()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Monthly") {
                        $trips = collect(Trip::Started()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Yearly") {
                        $trips = collect(Trip::Started()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Total") {
                        $trips = collect(Trip::with('owner', 'renter')->SearchDateRange($date_range)->SearchId($search)->SearchOwners($search)->SearchRenter($search)->ChunkData());
                    }
                }
                else if ($type == "pending") {
                    if($duration_type == "Active") {
                        $trips = collect(Trip::Pending()->SearchDateRange($date_range)->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Daily") {
                        $trips = collect(Trip::Pending()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Weekly") {
                        $trips = collect(Trip::Pending()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Monthly") {
                        $trips = collect(Trip::Pending()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Yearly") {
                        $trips = collect(Trip::Pending()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Total") {
                        $trips = collect(Trip::with('owner', 'renter')->SearchDateRange($date_range)->SearchId($search)->SearchOwners($search)->SearchRenter($search)->ChunkData());
                    }
                }
                else if ($type == "unfinished") {
                    if($duration_type == "Active") {
                        $trips = collect(Trip::Unfinished()->SearchDateRange($date_range)->SearchId($search)->SearchOwners($search)->SearchRenter($search)->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Daily") {
                        $trips = collect(Trip::Unfinished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Weekly") {
                        $trips = collect(Trip::Unfinished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Monthly") {
                        $trips = collect(Trip::Unfinished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Yearly") {
                        $trips = collect(Trip::Unfinished()->SearchId($search)->SearchOwners($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Total") {
                        $trips = collect(Trip::with('owner', 'renter')->SearchDateRange($date_range)->SearchId($search)->SearchOwners($search)->SearchRenter($search)->ChunkData());
                    }
                }
                if($type == "alltrips"){
                    if ($duration_type == "Active") {
                        $trips = collect(Trip::SearchOwners($search)->SearchDateRange($date_range)->SearchId($search)->SearchRenter($search)->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Daily") {
                        $trips = collect(Trip::SearchOwners($search)->SearchId($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfDay()->format('Y-m-d'), Carbon::now()->endOfDay()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Weekly") {
                        $trips = collect(Trip::SearchOwners($search)->SearchId($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfWeek()->format('Y-m-d'), Carbon::now()->endOfWeek()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Monthly") {
                        $trips = collect(Trip::SearchOwners($search)->SearchId($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfMonth()->format('Y-m-d'), Carbon::now()->endOfMonth()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Yearly") {
                        $trips = collect(Trip::SearchOwners($search)->SearchId($search)->SearchRenter($search)->SearchDateRange([Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])->with('owner', 'renter')->ChunkData());
                    }else if($duration_type == "Total") {
                        $trips = collect(Trip::with('owner', 'renter')->SearchDateRange($date_range)->SearchOwners($search)->SearchRenter($search)->ChunkData());
                    }
                }
                return new TripsResource($trips);
            }
        }
        else{
            dd('what');
        }

    }

    public function carsByCities()
    {
    	$cars = Car::where('car_is_active', true)->get();
    	$cities = $cars->unique('car_city')->flatten();
        $response = $cities->map(function ($item, $key) {
             $cities =  $item->car_city;
             $cars = Car::where('car_city', $item->car_city)->count();
             //$response = collect([$cities => $cars]);
             $response = collect(['city' => $cities, 'cars' => $cars]);
             return $response;
        });
        return response()->json($response, 200);
    }

	public function earners(Request $request)
	{
		$search = ($request->get('search') != null) ? $request->get('search') : '';
        $date_range = ($request->get('dates') != null) ? explode(',', $request->get('dates')) : [];
		$rowsPerPage = ($request->rowsPerPage) ? $request->rowsPerPage : 10;
		if ($search == ""  && empty($date_range)) {
			$earners = User::whereHas('owner', function($q){
				$q->where('status', 'finished');
			})->paginate($rowsPerPage);
		} else {
			$earners = User::whereHas('owner', function($q) use ($search) {
				$q->where('status', 'finished');
            })->SearchId($search)
            ->SearchFirstName($search)
            ->SearchLastName($search)
            ->SearchEmail($search)
            ->SearchPhone($search)
            ->SearchBankName($search)
            ->SearchIban($search)
            ->SearchAccountNumber($search)
            ->SearchDateRange($date_range)
            ->paginate($rowsPerPage);
		}
		return new UsersResource($earners);
	}

	public function earner($id)
	{
		$earner = User::with('bills', 'owner')->find($id);
		return new UserResource($earner);
	}
}
