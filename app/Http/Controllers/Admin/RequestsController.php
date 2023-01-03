<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class RequestsController extends Controller
{
    public function requests(Request $request)
    {
        $state =$request->request_state;
        if($state === 'expired' || $state === 'request' || $state === 'canceled' || $state === 'rejected'){
            $trips = DB::select('select trips.id, rider.name as rider_name , driver.name as driver_name, vechile.plate_number, trips.trip_type ,trips.reqest_time
            from trips  left join rider on trips.rider_id = rider.id
            left join driver on trips.driver_id = driver.id
            left join vechile on vechile.id= driver.current_vechile where trips.state= ?;', [$state]);
            return view('requests.requests', compact('trips', 'state'));
        }
        else{
            $trips = DB::select("select trips.id, rider.name as rider_name , driver.name as driver_name, vechile.plate_number, trips.trip_type ,trips.reqest_time
            from trips  left join rider on trips.rider_id = rider.id
            left join driver on trips.driver_id = driver.id
            left join vechile on vechile.id= driver.current_vechile where trips.state= 'pickedup' or trips.state = 'arrived' or trips.state = 'inprogress' ;");
            return view('requests.requests', compact('trips', 'state'));
        }
    }
}
