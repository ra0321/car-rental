<?php

namespace App\Http\Controllers;

use App\Http\Resources\TripsResource;
use App\Trip;
use App\TripBills;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Resources\TripResource as TripResource;

class TripsController extends Controller
{
    public function getTrip($id)
    {
    	$trip = Trip::with('car', 'tripBills', 'tripImages')->find($id);
    	return new TripResource($trip);
    }

    public function getTrips(Request $request)
    {
        $search = ($request->get('search') != null) ? $request->get('search') : '';
        $confirmed = ($request->get('confirmed') != null) ? $request->get('confirmed') : '';
        $date_range = ($request->get('dates') != null) ? explode(',', $request->get('dates')) : [];
        // dd($request->get('dates'));
        $rowsPerPage = ($request->rowsPerPage) ? $request->rowsPerPage : 10;
        if(isset($confirmed) && $confirmed != ''){
            if ($confirmed == 1) {
                if ($search == "" && empty($date_range)) {
                    $trips = Trip::Confirmed()->with('owner', 'renter')->paginate($rowsPerPage);
                } else {
                    $trips = Trip::Confirmed()->SearchOwners($search)
                        ->SearchId($search)
                        ->SearchRenter($search)
                        ->SearchStatus($search)
                        ->SearchDateRange($date_range)
                        ->with('owner', 'renter')
                        ->paginate($rowsPerPage);
                }
            }
            else if($confirmed == 2){
                if ($search == "" && empty($date_range)) {
                    $trips = Trip::Finished()->with('owner', 'renter')->paginate($rowsPerPage);
                } else {
                    $trips = Trip::Finished()->SearchOwners($search)
                        ->SearchId($search)
                        ->SearchRenter($search)
                        ->SearchStatus($search)
                        ->SearchDateRange($date_range)
                        ->with('owner', 'renter')
                        ->paginate($rowsPerPage);
                }
            }
            else if($confirmed == 3){
                if ($search == "" && empty($date_range)) {
                    $trips = Trip::Waiting()->with('owner', 'renter')->paginate($rowsPerPage);
                } else {
                    $trips = Trip::Waiting()->SearchOwners($search)
                        ->SearchId($search)
                        ->SearchRenter($search)
                        ->SearchStatus($search)
                        ->SearchDateRange($date_range)
                        ->with('owner', 'renter')
                        ->paginate($rowsPerPage);
                }
            }
            else if($confirmed == 0){
                if ($search == "" && empty($date_range)) {
                    $trips = Trip::Cancelled()->with('owner', 'renter')->paginate($rowsPerPage);
                } else {
                    $trips = Trip::Cancelled()->SearchOwners($search)
                        ->SearchId($search)
                        ->SearchRenter($search)
                        ->SearchStatus($search)
                        ->SearchDateRange($date_range)
                        ->with('owner', 'renter')
                        ->paginate($rowsPerPage);
                }
            }
        }
        else{
            if ($search == "" && empty($date_range)) {
                $trips = Trip::with('owner', 'renter')->paginate($rowsPerPage);
            } else {
                $trips = Trip::SearchOwners($search)
                    ->SearchId($search)
                    ->SearchRenter($search)
                    ->SearchStatus($search)
                    ->SearchDateRange($date_range)
                    ->with('owner', 'renter')
                    ->paginate($rowsPerPage);
            }
            // dd($trips);
        }
       
    	return new TripsResource($trips);
    }

   public function getTripsByOwner($id)
    {
     $trips = Trip::with('tripBills')->where('owner_id', $id)->get();
     return new TripsResource($trips);
    }

    public function getTripsByRenter($id)
    {
    	$trips = Trip::where('renter_id', $id)->get();
    	return new TripsResource($trips);
    }

    public function getTripsByStatus($status)
    {
    	$trips = Trip::where('status', $status)->get();
    	return new TripsResource($trips);
    }

    public function pay($id)
    {
        $tripBills = TripBills::where('trip_id', $id)->update(['esar_paid' => 1, 'esar_paid_date' => Carbon::now()]);
		$trip = Trip::with('car', 'tripBills', 'tripImages')->find($id);
        return new TripResource($trip);
    }

    public function getAntiFraudTrips()
    {
        $antiFraud = Trip::with('tripBills', 'owner', 'renter')->whereHas('tripBills', function($q){
            $q->where('trip_bill_status', 'on hold');
        })->get();

        return new TripsResource($antiFraud);
    }

    public function changeStopStatue($id) 
    {
        $trip = Trip::where('id', $id)->update([
            'status' => 'finished'
        ]);

        return response()->json('change sucess', 200);

    }
    public function changeCancelStatue($id) 
    {
        $trip = Trip::where('id', $id)->update([
            'status' => 'canceled'
        ]);

        return response()->json('change sucess', 200);

    }
    public function changeWaitingStatue($id) 
    {
        $trip = Trip::where('id', $id)->update([
            'status' => 'waiting'
        ]);

        return response()->json('change sucess', 200);

    }
    public function changeStartStatue($id) 
    {
        $trip = Trip::where('id', $id)->update([
            'status' => 'started'
        ]);

        return response()->json('change sucess', 200);

    }
}
