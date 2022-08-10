<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\User;
use DB;
use App\AllCar;
use App\Car;
use App\CarRegistration;
use App\CarFeatures;
use App\CarInsurance;
use App\CarImage;
use App\BookInstantly;
use App\CustomPrice;

class CarListController extends Controller
{
   public function getOwners(Request $request) {
       $search = $request['0'];
       $owners = User::select('email')->where('email', 'like','%' .$search.'%')->take(5)->get();
       return response()->json(['owners' => $owners,], 200);
   }

   public function chooseManufacturer($year) {
        $cars = DB::table('esar_cars')
        ->select('model_make_id AS manufacturer', 'manufacturer_arabic AS manufacturerArabic')
        ->where('model_year', $year)
        ->distinct()
        ->get();
    return response()->json(['data' => $cars], 200);
    }
    public function chooseModel(Request $request)
    {
        $models = DB::table('esar_cars')
            ->where('model_year', $request['year'])
            ->where('model_make_id', $request['manufacturer'])
            ->distinct()
            ->pluck('model_name');
        return response()->json(['data' => $models], 200);
    }
    public function getTransmission(Request $request)
    {
        $models = DB::table('esar_cars')
            ->select('model_transmission_type AS modelTransmissionType', 'model_transmission_type_arabic AS modelTransmissionTypeArabic')
            ->where('model_year', $request['year'])
            ->where('model_make_id', $request['manufacturer'])
            ->where('model_name', $request['model'])
            ->distinct()
            ->get();
        return response()->json(['data' => $models], 200);
    }
    public function getCarData(Request $request)
    {
        $models = AllCar::where('model_year', $request['year'])
            ->where('model_make_id', $request['manufacturer'])
            ->where('model_name', $request['model'])
            ->where('model_transmission_type', $request['transmission'])
            ->get();
            return response()->json(['data' => $models], 200);
    }

    public function addCar(Request $request) {
        $user_email = $request['user_email'];
        $user = User::where('email', $user_email)->get();
        $user_id = $user[0] ->id;
        $car = new Car;

        $cars = ['Compact Cars', 'Convertible', 'Coupe', 'Hatchback', 'Large Cars', 'Midsize Cars', 'Midsize Station Wagons', 'Mini Compact Cars', 'Roadster', 'Sedan', 'Small Station Wagons', 'Station Wagon', 'Subcompact Cars', 'Two Seaters'];
        $trucks = ['Pickup', 'Standard Pickup Trucks'];
        $suvs = ['Small Pickup Trucks', 'Crossover', 'Small Sport Utility Vehicles', 'Sport Utility Vehicles', 'Standard Sport Utility Vehicles', 'SUV'];
        $vans = ['Cargo Vans', 'Panel Van', 'Passenger Vans', 'Van'];
        $minivans = ['Minivan'];

        switch ($request['style']){
            case(in_array($request['style'], $cars)):
                $car->vehicle_type = 'Cars';
                $car->vehicle_type_arabic = 'سيارات';
                break;
            case(in_array($request['style'], $trucks)):
                $car->vehicle_type = 'Trucks';
                $car->vehicle_type_arabic = 'شاحنات';
                break;
            case(in_array($request['style'], $suvs)):
                $car->vehicle_type = 'SUVs';
                $car->vehicle_type_arabic = 'دفع رباعي';
                break;
            case(in_array($request['style'], $vans)):
                $car->vehicle_type = 'Vans';
                $car->vehicle_type_arabic = 'حافلة';
                break;
            case(in_array($request['style'], $minivans)):
                $car->vehicle_type = 'Minivans';
                $car->vehicle_type_arabic = 'حافلة صغيرة';
                break;
            default:
                $car->vehicle_type = 'Cars';
                $car->vehicle_type_arabic = 'سيارات';
                break;
        }

        $car->user_id                 = $user_id;
        $car->long_location           = $request['long_location'];
        $car->lat_location            = $request['lat_location'];
        $car->car_city                = $request['car_city'];
        $car->car_manufacturer        = $request['car_manufacturer'];
        $car->car_manufacturer_arabic = $request['car_manufacturer_arabic'];
        $car->car_model               = $request['car_model'];
        $car->production_year         = $request['production_year'];
        $car->model_class             = $request['model_class'];
        $car->trim                    = $request['trim'];
        $car->style                   = $request['style'];
        $car->car_transmission        = $request['car_transmission'];
        $car->brended                 = 1;
        $car->vehicle_type            = 'Cars';
        $car->vehicle_type_arabic     =  'سيارات  ';
        $car->car_value               = $request['car_value'];
        $car->car_odometer            = $request['car_odometer'].' KM';
        $car->phase                   = '100';
        $car->save();


        $carModel = AllCar::where('model_name', $request['car_model'])->get();
        if(!empty($carModel)){
            $carinfo = $carModel->first();

            $car_feture = new CarFeatures;
            $car_feture->car_id             = $car->id;
            $car_feture->model_seats        = $carinfo->model_seats;
            $car_feture->model_doors        = $carinfo->model_doors;
            $car_feture->model_engine_fuel  = $carinfo->model_engine_fuel;
            $car_feture->model_lkm_city     = $carinfo->model_lkm_city;
            $car_feture->model_lkm_hwy      = $carinfo->model_lkm_hwy;
            $car_feture->save();
        }

        $BookInstantly = new BookInstantly;
        $BookInstantly->car_id = $car->id;
        $BookInstantly->on_car_location = 0;
        $BookInstantly->on_airport = 0;
        $BookInstantly->on_guest_location = 0;
        $BookInstantly->work_on_guest_location = 0;
        $BookInstantly->save();


        $carPrice = new CustomPrice;
        $carPrice->car_id = $car->id;
        $carPrice->price  = 10;
        $carPrice->price_from_date = date('Y-m-d');
        $carPrice->save();

        return json_encode(['car' => $car], 200);
    }

    public function updateNotice(Request $request, $id) {
        $car = Car::find($id);
        $car->notice = $request['advance_notice'];
        $car->short_trip = $request['short_possible_trip'];
        $car->long_trip = $request['long_possible_trip'];
        $car->car_location_notice = $request['advance_notice'];
        $car->airport_notice = $request['advance_notice'];
        $car->guest_location_notice = $request['advance_notice'];
        $car->save();
        return json_encode(['message' =>"sucess"], 200);
    }

    public function carRegistration(Request $request, $id) {
        $car = Car::find($id);
        $small_image_policy_card = $original_car_registration_image = '';
        if(isset($request['images']) && !empty($request['images']) ){
            $image = $request['images'];
            $image_info = getimagesize($image);
            $extension = (isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");

            switch ($extension) {
                case 'png':
                        $image = str_replace('data:image/png;base64,', '', $image);
                    break;
                case 'jpg':
                        $image = str_replace('data:image/jpg;base64,', '', $image);
                    break;
                case 'jpeg':
                        $image = str_replace('data:image/jpeg;base64,', '', $image);
                    break;
                default:
                        $image = str_replace('data:image/png;base64,', '', $image);
                    break;
            }
            $image = str_replace(' ', '+', $image);
            $dir = 'cars/'.$id.'/ids';
            $small_image_policy_card = Str::random(30).'-small.'.$extension;
            $original_car_registration_image = Str::random(30).'-big.'.$extension;
            \Storage::disk('s3')->put($dir.'/'.$small_image_policy_card, base64_decode($image), 'public');
            \Storage::disk('s3')->put($dir.'/'.$original_car_registration_image, base64_decode($image), 'public');
        }

        $car_reg = new CarRegistration;
        $car_reg->car_id                            = $id;
        $car_reg->country                           = !empty($request['country']) ? $request['country'] : $request['state'];
        $car_reg->state                             = $request['state'];
        $car_reg->city                              = $request['city'];
        $car_reg->licence_plate                     = $request['licence_plate'];
        $car_reg->expiration_date                   = date( 'Y-m-d', strtotime($request['expiration_date']));
        $car_reg->date_of_issue                     = date( 'Y-m-d', strtotime($request['date_of_issue']));
        $car_reg->small_car_registration_image      = 'cars/'.$id.'/ids/'.$small_image_policy_card;
        $car_reg->original_car_registration_image   = 'cars/'.$id.'/ids/'.$original_car_registration_image;
        $car_reg->expired                           = 0;
        $car_reg->save();


        $cardetails = AllCar::where('id', $id)->get();
        $carinfo = [];
        if(!empty($cardetails)){
            $carinfo = $cardetails->first();
        }

        $carFeature = CarFeatures::where('car_id', $id)->get();
        if(!empty($carFeature)){
            $car_feture = $carFeature->first();
        }else{
            $car_feture = new CarFeatures;
        }

        $car_feture->car_id             = $id;
        $car_feture->hybrid             = in_array('hybrid', $request['carFeatures']) ? 1 : 0;
        $car_feture->bike_rack          = in_array('bike_rack', $request['carFeatures']) ? 1 : 0;
        $car_feture->all_drive          = in_array('all_drive', $request['carFeatures']) ? 1 : 0;
        $car_feture->child_seat         = in_array('child_seat', $request['carFeatures']) ? 1 : 0;
        $car_feture->gps                = in_array('gps', $request['carFeatures']) ? 1 : 0;
        $car_feture->ski_rack           = in_array('ski_rack', $request['carFeatures']) ? 1 : 0;
        $car_feture->bluetooth          = in_array('bluetooth', $request['carFeatures']) ? 1 : 0;
        $car_feture->usb                = in_array('usb', $request['carFeatures']) ? 1 : 0;
        $car_feture->ventilated_seat    = in_array('ventilated_seat', $request['carFeatures']) ? 1 : 0;
        $car_feture->audio_input        = in_array('audio_input', $request['carFeatures']) ? 1 : 0;
        $car_feture->convertible        = in_array('convertible', $request['carFeatures']) ? 1 : 0;
        $car_feture->toll_pass          = in_array('toll_pass', $request['carFeatures']) ? 1 : 0;
        $car_feture->sunroof            = in_array('sunroof', $request['carFeatures']) ? 1 : 0;
        $car_feture->pet_friendly       = in_array('pet_friendly', $request['carFeatures']) ? 1 : 0;
        $car_feture->heated_seat        = in_array('heated_seat', $request['carFeatures']) ? 1 : 0;
        $car_feture->car_title          = $car->car_manufacturer_arabic.' '.$car->car_model;
        $car_feture->car_description    = $request['carDescription'];
        $car_feture->save();
        return json_encode(['message' =>"sucess"], 200);
    }

    public function carProtection(Request $request, $id) {
        $car_ins = new CarInsurance;
        $image_policy_card = $small_image_policy_card = '';

        if(isset($request['images']) && !empty($request['images']) ){
            $image = $request['images'];
            $image_info = getimagesize($image);
            $extension = (isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");

            switch ($extension) {
                case 'png':
                        $image = str_replace('data:image/png;base64,', '', $image);
                    break;
                case 'jpg':
                        $image = str_replace('data:image/jpg;base64,', '', $image);
                    break;
                case 'jpeg':
                        $image = str_replace('data:image/jpeg;base64,', '', $image);
                    break;
                default:
                        $image = str_replace('data:image/png;base64,', '', $image);
                    break;
            }
            $image = str_replace(' ', '+', $image);
            $dir = 'cars/'.$id.'/insurance';
            $image_policy_card = Str::random(30).'-small.'.$extension;
            $small_image_policy_card = Str::random(30).'-big.'.$extension;
            \Storage::disk('s3')->put($dir.'/'.$image_policy_card, base64_decode($image), 'public');
            \Storage::disk('s3')->put($dir.'/'.$small_image_policy_card, base64_decode($image), 'public');
        }
        $car_ins->car_id                            = $id;
        $car_ins->policy_number                     = $request['policy_number'];
        $car_ins->detectable_amount  = $request['detectable_amount'];
        $car_ins->expiration_date                   = date( 'Y-m-d', strtotime($request['expiration_date']));
        $car_ins->date_of_issue                     = date( 'Y-m-d', strtotime($request['date_of_issue']));
        $car_ins->expired                           = 0;
        $car_ins->image_policy_card                 = 'cars/'.$id.'/insurance/'.$image_policy_card;
        $car_ins->small_image_policy_card           = 'cars/'.$id.'/insurance/'.$small_image_policy_card;
        $car_ins->save();
        return json_encode(['message' =>"sucess"], 200);
    }

    public function carPhotos(Request $request, $id) {
        if(isset($request['images']) && !empty($request['images'])){
            $dir = 'cars/'.$id.'/';
            /*if(!is_dir(storage_path(). '/cars')){
                mkdir( storage_path(). '/cars');
            }
            if(!is_dir(storage_path(). '/cars/'.$id)){
                mkdir( storage_path(). '/cars/'.$id);
            }*/
            for ($i=0; $i < sizeof($request['images']); $i++) { 
                $image = $request['images'][$i]['thumbUrl'];

                $image_info = getimagesize($image);
                $extension = (isset($image_info["mime"]) ? explode('/', $image_info["mime"] )[1]: "");

                switch ($extension) {
                    case 'png':
                            $image = str_replace('data:image/png;base64,', '', $image);
                        break;
                    case 'jpg':
                            $image = str_replace('data:image/jpg;base64,', '', $image);
                        break;
                    case 'jpeg':
                            $image = str_replace('data:image/jpeg;base64,', '', $image);
                        break;
                    default:
                            $image = str_replace('data:image/png;base64,', '', $image);
                        break;
                }
                $image = str_replace(' ', '+', $image);

                $original_image_path = Str::random(30).'-small.'.$extension;
                $big_image_path      = Str::random(30).'-big.'.$extension;
                $small_image_path    = Str::random(30).'-small.'.$extension;
                $icon_image_path     = Str::random(30).'-smallest.'.$extension;
                \Storage::disk('s3')->put($dir.'/'.$original_image_path, base64_decode($image), 'public');
                \Storage::disk('s3')->put($dir.'/'.$big_image_path, base64_decode($image), 'public');
                \Storage::disk('s3')->put($dir.'/'.$small_image_path, base64_decode($image), 'public');
                \Storage::disk('s3')->put($dir.'/'.$icon_image_path, base64_decode($image), 'public');

                $car_imgs = new CarImage;
                $car_imgs->car_id              = $id;
                $car_imgs->original_image_path = 'cars/'.$id.'/'.$original_image_path;
                $car_imgs->big_image_path      = 'cars/'.$id.'/'.$big_image_path;
                $car_imgs->small_image_path    = 'cars/'.$id.'/'.$small_image_path;
                $car_imgs->icon_image_path     = 'cars/'.$id.'/'.$icon_image_path;
                $car_imgs->save();
            }
        }
        return json_encode(['message' =>"sucess"], 200);
    }

}
