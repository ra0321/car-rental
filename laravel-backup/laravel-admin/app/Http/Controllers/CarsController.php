<?php

namespace App\Http\Controllers;

use App\User;
use App\Car;
use App\CarImage;
use Illuminate\Http\Request;
use App\Http\Resources\CarResource as CarResource;
use App\Http\Resources\CarsResource as CarsResource;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CarsController extends Controller
{
    public function getCar($id)
    {
    	$car = Car::with('carImage', 'user')->find($id);
    	return new CarResource($car);
    }

    public function getCars(Request $request)
    {
        $active = ($request->get('active') != null) ? $request->get('active') : '';
        $verified = ($request->get('verified') != null) ? $request->get('verified') : '';
        $search = ($request->get('search') != null) ? $request->get('search') : '';
        $date_range = ($request->get('dates') != null) ? explode(',', $request->get('dates')) : [];
        $rowsPerPage = ($request->rowsPerPage) ? $request->rowsPerPage : 10;
        if ($active != "") {
            if ($search == ""  && empty($date_range)) {
                $cars = Car::with('user')
                    ->where('car_is_active', $active)
                    ->paginate($rowsPerPage);
            } else {
                $cars = Car::whereHas('user', function($q) use($search) {
                    $q->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('id', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone_number', 'like', '%'.$search.'%');
                })->where('car_is_active', $active)->SearchCarManufacturer($search)
                    ->SearchCarId($search)
                    ->SearchCarModel($search)
                    ->SearchCarProdYear($search)
                    ->SearchCarModelClass($search)
                    ->SearchCarCity($search)
                    ->SearchDateRange($date_range)
                    ->where('car_is_active', $active)
                    ->with('user')
                    ->paginate($rowsPerPage);
            }
        }
        else if ($verified != "") {
            if ($search == ""  && empty($date_range)) {
                // dd(Car::with('user')
                // ->where('is_insurance_verified', $verified)
                // ->orWhere('is_registration_car_verified', $verified)->count());
                $cars = Car::with('user')
                    ->where('is_insurance_verified', $verified)
                    ->where('is_registration_car_verified', $verified)
                    ->paginate($rowsPerPage);
            } else {
                $cars = Car::whereHas('user', function($q) use($search) {
                    $q->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('id', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone_number', 'like', '%'.$search.'%');
                })->SearchCarManufacturer($search)
                    ->SearchCarId($search)
                    ->SearchCarModel($search)
                    ->SearchCarProdYear($search)
                    ->SearchCarModelClass($search)
                    ->SearchCarCity($search)
                    ->SearchDateRange($date_range)
                    ->where('is_insurance_verified', $verified)
                    ->where('is_registration_car_verified', $verified)
                    ->with('user')
                    ->paginate($rowsPerPage);
            }
        }
        else{
            if ($search == ""  && empty($date_range)) {
                $cars = Car::with('user')->paginate($rowsPerPage);
            } else {
                $cars = Car::whereHas('user', function($q) use($search) {
                    $q->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('id', 'like', '%'.$search.'%')
                    ->orWhere('last_name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%')
                    ->orWhere('phone_number', 'like', '%'.$search.'%');
                })->SearchCarManufacturer($search)
                    ->SearchCarId($search)
                    ->SearchCarModel($search)
                    ->SearchCarProdYear($search)
                    ->SearchCarModelClass($search)
                    ->SearchCarCity($search)
                    ->SearchDateRange($date_range)
                    ->with('user')
                    ->paginate($rowsPerPage);
            }

        }
    	return new CarsResource($cars);
    }

    public function getCarsByUser($id)
    {
    	$cars = Car::where('user_id', $id)->get();
    	return new CarsResource($cars);
    }

    public function getImagesByCar($id)
    {
        $images = CarImage::where('car_id', $id)->get();
        return $images;
    }

    public function deleteCar($id)
    {
        $car = Car::find($id);
        $now = Carbon::now();
        $car->update([
            'car_is_active' => false,
            'is_deleted' => true
        ]);

        DB::table('car_unlisteds')->where('car_id', $id)->insert([
            'car_id' => $car->id,
            'car_status' => 'deleted',
            'admin_delete' => true,
            'created_at' => $now,
            'updated_at' => $now
        ]);
		$user = User::find($car->user_id);
		$user['listed'] = $user['listed'] + 1;
		$user->save();

        return response()->json(['Car is deleted'], 200);
    }

    public function restoreCar($id)
    {
        $car = Car::find($id);
        $now = Carbon::now();
        $car->update([
            'car_is_active' => true,
            'is_deleted' => false
        ]);

        DB::table('car_unlisteds')->where('car_id', $id)->insert([
            'car_id' => $car->id,
            'car_status' => 'listed',
            'admin_delete' => false,
            'created_at' => $now,
            'updated_at' => $now
        ]);

        return response()->json(['Car is restored'], 200);
    }

    public function getCarInsurance($id)
    {

        $insurance = DB::table('car_insurances')->where('car_id', $id)->first();
        if(!$insurance)
        {
            return response()->json(['No insurance data'], 200);
        }
        return response()->json($insurance, 200);
    }

    public function getCarRegistration($id)
    {

        $registration = DB::table('car_registrations')
                          ->where('car_id', $id)
                          ->orderBy('created_at', 'desc')
                          ->first();
        if(!$registration)
        {
            return response()->json(['No registration data'], 200);
        }
        return response()->json($registration, 200);
    }

   public function approveInsurance($id)
    {
        $car = Car::find($id);
        $car->update([
            'is_insurance_verified' => true
        ]);

        return response()->json('Insurance approved', 200);
    }

   public function approveRegistration($id)
    {
        $car = Car::find($id);
        $car->update([
            'is_registration_car_verified' => true
        ]);

        return response()->json('Registration approved', 200);
    }

   public function denyInsurance($id)
    {
        $car = Car::find($id);
        $car->update([
            'is_insurance_verified' => false
        ]);

        return response()->json('Insurance denied', 200);
    }

   public function denyRegistration($id)
    {
        $car = Car::find($id);
        $car->update([
            'is_registration_car_verified' => false
        ]);

        return response()->json('Registration denied', 200);
    }
}
