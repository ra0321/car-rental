<?php

namespace App\Http\Controllers\car;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Car\CarStoreRules;
use App\Http\Requests\Car\CarUpdateRules;
use App\Http\Requests\Car\CarDepositRules;
use App\Http\Requests\Car\ReportListingRules;

use App\Car;
use App\Events\UpdateCarAirportsEvent;
use App\Exceptions\CustomException;
use App\Helpers\Currency\CurrencyHelper;
use App\Report;
use App\Traits\PriceForDay;
use App\User;
use App\AllCar;
use App\FavoriteCar;
use App\RecentlyViewedCar;
use App\Events\Car\ListCar;

class CarController extends Controller
{
	use TokenAuthorization, PriceForDay;
    //
	public function store(CarStoreRules $request)
	{
		$user = $this->authenticateUserByToken();
        $data = $request->only(
            'long_location', 'lat_location', 'car_city', 'car_manufacturer',
            'car_model', 'production_year', 'car_transmission', 'brended', 'car_odometer',
            'car_value', 'real_odometer', 'trim', 'style'
        );

		if(!$this->isEnglish($data['car_city'])){
			$data['car_city'] = $this->getLocality($data);
		};

        $car_model = AllCar::findOrFail($request['car_model_id']);
        $cars = ['Compact Cars', 'Convertible', 'Coupe', 'Hatchback', 'Large Cars', 'Midsize Cars', 'Midsize Station Wagons', 'Mini Compact Cars', 'Roadster', 'Sedan', 'Small Station Wagons', 'Station Wagon', 'Subcompact Cars', 'Two Seaters'];
        $trucks = ['Pickup', 'Standard Pickup Trucks'];
        $suvs = ['Small Pickup Trucks', 'Crossover', 'Small Sport Utility Vehicles', 'Sport Utility Vehicles', 'Standard Sport Utility Vehicles', 'SUV'];
        $vans = ['Cargo Vans', 'Panel Van', 'Passenger Vans', 'Van'];
        $minivans = ['Minivan'];

		$car = new Car([
			'user_id' => $user->id,
            'phase' => '20',
            'car_manufacturer_arabic' => $car_model['manufacturer_arabic'],
            'model_class' => $car_model['model_class'],
		]);

		$features['model_seats'] = $car_model['model_seats'];
		$features['model_doors'] = $car_model['model_doors'];
		$features['model_engine_fuel'] = $car_model['model_engine_fuel'];
		$features['model_lkm_city'] = $car_model['model_lkm_city'];
		$features['model_lkm_hwy'] = $car_model['model_lkm_hwy'];

        $car->updateLoop($data, $car);

		switch ($request['style']){
            case(in_array($request['style'], $cars)):
                $car['vehicle_type'] = 'Cars';
                $car['vehicle_type_arabic'] = 'سيارات';
                break;
            case(in_array($request['style'], $trucks)):
                $car['vehicle_type'] = 'Trucks';
                $car['vehicle_type_arabic'] = 'شاحنات';
                break;
            case(in_array($request['style'], $suvs)):
                $car['vehicle_type'] = 'SUVs';
                $car['vehicle_type_arabic'] = 'دفع رباعي';
                break;
            case(in_array($request['style'], $vans)):
                $car['vehicle_type'] = 'Vans';
                $car['vehicle_type_arabic'] = 'حافلة';
                break;
            case(in_array($request['style'], $minivans)):
                $car['vehicle_type'] = 'Minivans';
                $car['vehicle_type_arabic'] = 'حافلة صغيرة';
                break;
            default:
                $car['vehicle_type'] = 'Cars';
                $car['vehicle_type_arabic'] = 'سيارات';
                break;
        }

		try{
		    DB::beginTransaction();
		    $car->save();
            event(new ListCar($car, $request, $features));
            DB::commit();
            return $this->showOne($car, 201);
        }catch (\PDOException $exception){
            DB::rollBack();
            return $this->errorResponse(SOMETHING_WENT_WRONG);
        }
	}
	
	
	
	
	public function show(Car $car)
	{
        Request()->header('Authorization') ? $user = $this->authenticateUserByToken() : $user = null;
        if($user){
            $isFavorite = FavoriteCar::whereCarId($car->id)->where('user_id', $user->id)->first();
            if($isFavorite){
                $car['isFavorite'] = true;
            }
            $recentlyViewed = RecentlyViewedCar::where('user_id', $user->id)->where('car_id', $car->id)->first();
            /*$myCar = $user->id === $car->user_id ? true : false;
            if(!$recentlyViewed && !$myCar){*/
            if(!$recentlyViewed){
                $recent = new RecentlyViewedCar();
                $recent['user_id'] = $user['id'];
                $recent['car_id'] = $car->id;
                try{
                    DB::beginTransaction();
                    $count = RecentlyViewedCar::whereUserId($user['id'])->count();
                    if($count > 7){
                        $last = RecentlyViewedCar::whereUserId($user['id'])->orderBy('created_at', 'asc')->first();
                        $last->delete();
                    }
                    $recent->save();
                    DB::commit();
                }catch (\PDOException $e){
                    DB::rollBack();
	                return $this->errorResponse(SOMETHING_WENT_WRONG);
                }
            }
        }
		return $this->showOne($car);
	}
	
	
	
	
	public function update(CarUpdateRules $request, Car $car)
	{
		$user = $this->authenticateUserByToken();
		$this->checkUser($user->id, $car);
        $data = $request->only(
            'long_location', 'lat_location', 'car_city', 'car_manufacturer',
            'car_model', 'production_year', 'car_transmission', 'brended', 'car_odometer',
            'car_value', 'real_odometer', 'trim', 'style'
        );

		if(!$this->isEnglish($data['car_city'])){
			$data['car_city'] = $this->getLocality($data);
		};

        $car_model = AllCar::findOrFail($request['car_model_id']);
        $cars = ['Compact Cars', 'Convertible', 'Coupe', 'Hatchback', 'Large Cars', 'Midsize Cars', 'Midsize Station Wagons', 'Mini Compact Cars', 'Roadster', 'Sedan', 'Small Station Wagons', 'Station Wagon', 'Subcompact Cars', 'Two Seaters'];
        $trucks = ['Pickup', 'Standard Pickup Trucks'];
        $suvs = ['Small Pickup Trucks', 'Crossover', 'Small Sport Utility Vehicles', 'Sport Utility Vehicles', 'Standard Sport Utility Vehicles', 'SUV'];
        $vans = ['Cargo Vans', 'Panel Van', 'Passenger Vans', 'Van'];
        $minivans = ['Minivan'];

        $car['car_manufacturer_arabic'] = $car_model['manufacturer_arabic'];
        $car['model_class'] = $car_model['model_class'];

        $features['model_seats'] = $car_model['model_seats'];
        $features['model_doors'] = $car_model['model_doors'];
        $features['model_engine_fuel'] = $car_model['model_engine_fuel'];
        $features['model_lkm_city'] = $car_model['model_lkm_city'];
        $features['model_lkm_hwy'] = $car_model['model_lkm_hwy'];

		$user->updateLoop($data, $car);

        switch ($request['style']){
            case(in_array($request['style'], $cars)):
                $car['vehicle_type'] = 'Cars';
                $car['vehicle_type_arabic'] = 'سيارات';
                break;
            case(in_array($request['style'], $trucks)):
                $car['vehicle_type'] = 'Trucks';
                $car['vehicle_type_arabic'] = 'شاحنات';
                break;
            case(in_array($request['style'], $suvs)):
                $car['vehicle_type'] = 'SUVs';
                $car['vehicle_type_arabic'] = 'دفع رباعي';
                break;
            case(in_array($request['style'], $vans)):
                $car['vehicle_type'] = 'Vans';
                $car['vehicle_type_arabic'] = 'حافلة';
                break;
            case(in_array($request['style'], $minivans)):
                $car['vehicle_type'] = 'Minivans';
                $car['vehicle_type_arabic'] = 'حافلة صغيرة';
                break;
            default:
                $car['vehicle_type'] = 'Cars';
                $car['vehicle_type_arabic'] = 'سيارات';
                break;
        }

		isset($data['car_odometer']) ? $car['car_odometer'] = $data['car_odometer'] : $car['car_odometer'] = null;
		isset($data['real_odometer']) ? $car['real_odometer'] = $data['real_odometer'] : $car['real_odometer'] = null;
		$car['is_registration_car_verified'] = false;
		$carLocation = [];
		$carLocation['long_location'] = $data['long_location'];
		$carLocation['lat_location'] = $data['lat_location'];
		event(new UpdateCarAirportsEvent($carLocation, $car));

		$car['phase'] = '20';
		$car->save();
		return $this->showOne($car);
	}
	
	
	public function reportListing(ReportListingRules $request, Car $car)
    {
        $user = $this->authenticateUserByToken();
        $data = $request->only('inappropriate', 'misleading', 'spam', 'other', 'reason');
        $checkUser = Report::where('user_reported', $user->id)->where('car_id', $car->id)->count();
        if($checkUser > 0){
            throw new CustomException(YOU_ALREADY_REPORT_THIS_CAR);
        }
        $report = new Report();
        $inappropriate = isset($data['inappropriate']) ? $report->changeToBool($data['inappropriate']) : null;
        $misleading = isset($data['misleading']) ? $report->changeToBool($data['misleading']) : null;
        $spam = isset($data['spam']) ? $report->changeToBool($data['spam']) : null;
        $other = isset($data['other']) ? $report->changeToBool($data['other']) : null;


        if(isset($other) && $other === true){
            $report['other'] = $data['other'];
            $report['reason'] = $data['reason'];
            $report['user_reported'] = $user->id;
            $report['car_id'] = $car->id;
        }else {
            $report['inappropriate'] = isset($inappropriate) ? $inappropriate : null;
            $report['misleading'] = isset($misleading) ? $misleading : null;
            $report['spam'] = isset($spam) ? $spam : null;
            $report['user_reported'] = $user->id;
            $report['car_id'] = $car->id;
        }
        $report->save();
        return $this->successResponseWithMessage(YOU_JUST_REPORTED_THIS_CAR);
    }
}
