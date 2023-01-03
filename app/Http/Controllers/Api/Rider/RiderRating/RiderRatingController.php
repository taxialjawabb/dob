<?php

namespace App\Http\Controllers\Api\Rider\RiderRating;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating\CategoryRating;
use App\Models\Rating\DriverRating;
use App\Models\Driver;
use App\Models\Category;
use App\Models\Trip;
use App\Traits\GeneralTrait;
use Carbon\Carbon;


class RiderRatingController extends Controller
{
    use GeneralTrait;
    public function rider_add_rating(Request $request)
    {
        $request->validate([
            'trip_id' =>'required',
            'driver_rate' =>'required|numeric',
            'vechile_rate' =>'required|numeric',
            'cost_rate' =>'required|numeric',
            'time_rate' =>'required|numeric',
            ]);
        $trip = Trip::find($request->trip_id);
        if($trip !== null){
            if($trip->state != 'expired'){
            return $this->returnError('E003', 'هذه الرحلة لم تكتمل ');
            }else{
                $driver = Driver::find($trip->driver_id);
                if($driver !== null){
                    if($request->driver_rate != -1){
                        $driver->driver_rate += $request->driver_rate;
                        $driver->driver_counter ++ ;
                        DriverRating::create([
                            'rate_type' => 'driver',
                            'rate' => $request->driver_rate,
                            'content' => $request->driver_content,
                            'added_date' => Carbon::now(),
                            'rider_id' => $trip->rider_id,
                            'driver_id' => $trip->driver_id,
                        ]);
                    }
                    if($request->vechile_rate != -1){
                        $driver->vechile_rate += $request->vechile_rate;
                        $driver->vechile_counter ++ ;
                        DriverRating::create([
                            'rate_type' => 'vechile',
                            'rate' => $request->vechile_rate,
                            'content' => $request->vechile_content,
                            'added_date' => Carbon::now(),
                            'rider_id' => $trip->rider_id,
                            'driver_id' => $trip->driver_id,
                        ]);
                    }
                    if($request->time_rate != -1){
                        $driver->time_rate += $request->time_rate;
                        $driver->time_counter ++ ;
                        DriverRating::create([
                            'rate_type' => 'time',
                            'rate' => $request->time_rate,
                            'content' => $request->time_content,
                            'added_date' => Carbon::now(),
                            'rider_id' => $trip->rider_id,
                            'driver_id' => $trip->driver_id,
                        ]);
                    }
                    $driver->save();
                }
                $cat = Category::find($trip->vechile_id);
                if($cat !== null){
                    if($request->cost_rate != -1){
                        $cat->rate += $request->cost_rate;
                        $cat->rate_counter ++ ;
                        $cat->save();
                        CategoryRating::create([
                            'rate' => $request->cost_rate,
                            'content' => $request->cost_content,
                            'added_date' => Carbon::now(),
                            'rider_id' => $trip->rider_id,
                            'category_id' => $trip->vechile_id,
                        ]);
                    }
                }
                return $this -> returnSuccessMessage('تم تقيم الرحلة شكرا لك لاستخدام تاكسى الجواب');                
            }
        }
        else{
            return $this->returnError('E003', 'هذه الرحلة لم تعد متاحه');
        }
    }
}
