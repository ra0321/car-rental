<?php

namespace App\Http\Controllers;

use App\Http\Resources\RentalCalculatorCollectionResource;
use App\RentalCalculator;
use Illuminate\Http\Request;

class RentalCalculatorController extends Controller
{
    public function index(Request $request)
    {
        $search = ($request->get('search') != null) ? $request->get('search') : '';
        $date_range = ($request->get('dates') != null) ? explode(',', $request->get('dates')) : [];
		$rowsPerPage = ($request->rowsPerPage) ? $request->rowsPerPage : 10;
        if ($search == ""  && empty($date_range)) {
            $calculator = RentalCalculator::paginate($rowsPerPage);
        } else {
            $calculator = RentalCalculator::SearchId($search)
                ->SearchEmail($search)
                ->SearchPhone($search)
                ->SearchCarManufacturer($search)
                ->SearchCarManufacturerArabic($search)
                ->SearchCarModel($search)
                ->SearchCarModelClass($search)
                ->SearchCarProdYear($search)
                ->SearchCarTransmission($search)
                ->SearchCarTransmissionArabic($search)
                ->SearchCarValue($search)
                ->SearchVehicleType($search)
                ->SearchVehicleTypeArabic($search)
                ->SearchCarOdometer($search)
                ->SearchCarRealOdometer($search)
                ->SearchCarDailyPrice($search)
                ->SearchCarTearlyPrice($search)
                ->SearchDateRange($date_range)
                ->paginate($rowsPerPage);
        }
    	return new RentalCalculatorCollectionResource($calculator);
    }
}
