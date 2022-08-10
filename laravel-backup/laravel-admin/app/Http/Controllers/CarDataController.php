<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EsarCars;


class CarDataController extends Controller
{
    public function getEsarCar(Request $request)
    {
        $page = $request->get('page');
        // $request->get('dates')
        $results = $request->get('results');
        if (empty($results)) {
            $datas = EsarCars::select("*")->skip(($page-1)*10)->take(10)->get();
        }
        if ($results == 10 ){
            $datas = EsarCars::select("*")->skip(($page-1)*10)->take(10)->get();
        } else if ($results == 20) {
            $datas = EsarCars::select("*")->skip(($page-1)*20)->take(20)->get();
        } else if ($results == 50) {
            $datas = EsarCars::select("*")->skip(($page-1)*50)->take(50)->get();
        } else if ($results == 100) {
            $datas = EsarCars::select("*")->skip(($page-1)*100)->take(100)->get();
        };
       
        $meta = EsarCars::select("*")->count();
        $total = ceil($meta / 10);
        return response()->json(['data' => $datas, 'total'=>$meta], 200);
    }

    public function createCar(Request $request)
    {
        $id = EsarCars::select('*')->count();
        // $id = $count + 1;
        EsarCars::create([
            'id' => $id,
            'model_make_id' => $request['make'],
            'manufacturer_arabic' => "",
            'model_class' => "classic",
            'model_name' => $request['model'],
            'model_year' => $request['year'],
            'model_transmission_type' =>$request['transmission'],
            'model_transmission_type_arabic' =>$request['ناقل حركة أوتوماتيكي']",
            'model_trim' => $request['trim'],
            'model_body' => $request['style'],
            'model_engine_fuel' => "Gasoline"
        ]);
        return response()->json("message: sucess");
    }

    public function updateCar(Request $request) {
        $id = $request['id'];
        EsarCars::where('id', $id)
                ->update(['model_body' => $request->input('model'),
                         'model_year'=>$request->input('year'),
                         'model_make_id'=>$request->input('make'),
                         'model_trim'=>$request->input('trim'),
                         'model_transmission_type'=>$request->input('transmission'),
                         'model_name'=>$request->input('style')]
                        );
        return response()->json(['message' => "CarData updated successfully"], 200);
    }

    public function deleteCar($id)  
    {
        EsarCars::where('id', $id)->delete();
        return response()->json(['message' => "CarData deleted successfully"], 200);
    }
}
