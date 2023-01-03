<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rider;
use App\Models\Driver;
use App\Models\Vechile;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\SecondaryCategory;
use App\Traits\GeneralTrait;
use App\Traits\TripCost;


class TripController extends Controller
{
    public function __construct()
        {
            set_time_limit(300);
        }
    use GeneralTrait;
    use TripCost;

    public function request(Request $request)
    {
        $request->validate([
            // 'trip_type' =>'required|string|in:internal,city',
            'rider_id' =>'required',
            'category_id' =>'required',
            'start_loc_latitude' =>'required|numeric',
            'start_loc_longtitude' =>'required|numeric',
            'start_loc_name' =>'required|string',
            'start_loc_id' =>'required',
            // 'end_loc_latitude' =>'required|numeric',
            // 'end_loc_longtitude' =>'required|numeric',
            // 'end_loc_name' =>'required',
            // 'end_loc_id' =>'required',
            'reqest_time' =>'required',
            'distance' =>'required',
            'trip_time' =>'required',
            'total_cost' => 'required|numeric',
            'driver_cost' => 'required|numeric',
            'company_cost' => 'required|numeric',
            'cancel_cost' => 'required|numeric',
            'reject_cost' => 'required|numeric',
            'basic_price' => 'required|numeric',
            'km_cost' => 'required|numeric',
            'fixed_percentage' => 'required|numeric',
            'category_percent' => 'required|numeric',
            'payment_percentage' => 'required|string',
            ]);

            $rider = Rider::find($request->rider_id);

            if($rider !== null){
                $data =  $this->insertTrip($request);


                $cat = Category::find($request->category_id);
                $drivers = Driver::select(['driver.id', 'driver.name', 'remember_token', 'vechile.secondary_id'])
                ->leftJoin('vechile', 'driver.current_vechile', '=', 'vechile.id')
                ->where('driver.account' , '>', 0 )
                ->where('vechile.category_id' , $request->category_id)->get();
                $data->basic_price   =$cat->basic_price ;
                $data->km_cost   =$cat->km_cost ;
                $data->minute_cost   =$cat->minute_cost ;
                $data->phone   = $rider->phone ;
                $data->name   = $rider->name;
                $data->idTrip = $data->id;
                foreach ($drivers as $driver) {

                    $sec = SecondaryCategory::find($driver->secondary_id);
                    if($sec !== null){
                        $data->percentage_type   =$sec->percentage_type ;
                        $data->category_percent   =$sec->category_percent ;
                        $this->push_notification( $driver->remember_token , 'تم أضافة رحلة جديدة' , $data,'new_trip' );
                    }
                }

                return $this -> returnData('data' , $data,'تم حفظ طلبك قيد الانتظار');
            }else{
                return $this->returnError('E001', 'حدث خطاء الرجاء المحاولة فى وقت لاحق');
            }
    }

    private function cmp($a, $b) {
        return $a->distance > $b->distance;
    }

    private function insertTrip($request)
    {
        $trip = new Trip;

        $trip->state = 'request' ;
        $trip->trip_type = 'internal';
        $trip->rider_id = $request->rider_id;
        $trip->start_loc_latitude = number_format($request->start_loc_latitude, 15, '.', ',') ;
        $trip->start_loc_longtitude = number_format($request->start_loc_longtitude, 15, '.', ',') ;
        $trip->start_loc_name = $request->start_loc_name;
        $trip->start_loc_id = $request->start_loc_id;
        if($request->end_loc_latitude !== null || $request->end_loc_longtitude !== null){
            $trip->end_loc_latitude = number_format( $request->end_loc_latitude, 15, '.', ',') ;
            $trip->end_loc_longtitude = number_format( $request->end_loc_longtitude, 15, '.', ',') ;
            $trip->end_loc_name = $request->end_loc_name;
            $trip->end_loc_id = $request->end_loc_id;
        }
        $trip->reqest_time =  $request->reqest_time;
        $trip->distance = ceil($request->distance);
        $trip->trip_time = $request->trip_time;

        $trip->vechile_id = $request->category_id ;
        $trip->cost = $request->total_cost ;

        $trip->save();
        return $trip;
    }
    private function driverUpdate($id, $available){
        $driver = Driver::find($id);
        $driver->available = $available;
        $driver->save();
    }

    public function cancel(Request $request)
    {
        $request->validate([
            'trip_id' =>'required',
            'cancel_cost' =>'required',

            ]);
        $trip = Trip::find($request->trip_id);

        if( $trip !== null){
            if( $trip->state == 'canceled'){
                return $this->returnError('E003', " لقد تم إلغاء هذه الرحلة");
            }
            else if( $trip->state == 'expired'){
                return $this->returnError('E003',"هذه الرحلة مكتملة");
            }
            $trip->state = 'canceled';
            $trip->trip_end_time = Carbon::now() ;
            if($trip->driver_id != null){
                //$this->driverUpdate($trip->driver_id, true);
                $driver = Driver::find($trip->driver_id);

                if($driver != null ){
                    $this->push_notification( $driver->remember_token , "تم إلغاء الرحلة", $trip->id,'cancel');
                    if($request->cancel_cost > 0){

                            $vechile = Vechile::find($driver->current_vechile);
                            $rider = Rider::find($trip->rider_id);
                            if($vechile != null && $rider != null){
                                $boxVechile = \App\Models\Vechile\BoxVechile::create([
                                    'vechile_id' => $driver->current_vechile,
                                    'foreign_type' => 'rider',
                                    'foreign_id' => $rider->id,
                                    'bond_type' => 'take',
                                    'payment_type' => 'internal transfer',
                                    'bond_state' => 'deposited',
                                    'descrpition' => 'تم خصم مبلغ  ' .$request->cancel_cost. ' عائد للمركبة رقم ' .$vechile->id .' على رحلة رقم ' .$trip->id ,
                                    'money' => $request->cancel_cost,
                                    'tax' => 0,
                                    'total_money' => $request->cancel_cost,
                                    'add_date' => Carbon::now(),
                                ]);
                                $trip->payment_type = 'internal transfer';
                                $trip->cost = $request->cancel_cost;
                                $rider->account   -=  $request->cancel_cost;
                                $vechile->account +=  $request->cancel_cost;

                                $rider->save();
                                $vechile->save();
                                $message =  "تم خصم مبلغ  " .$request->cancel_cost . " من حسابك لألغاء الرحلة";
                                $rider->message = $message;
                                $this->push_notification( $rider->remember_token , 'تم خصم من الرصيد' , $rider,'discount' );
                            }

                }

                }
            }

            $trip->save();
            return $this->returnSuccessMessage("trip canceled");

        }
        else{
            return $this->returnError('E003', 'هذه الرحلة غير متاحه');
        }
    }

    public function cancel_reqest_time(Request $request)
    {
        $request->validate([
            'rider_id' =>'required',
            'reqest_time' =>'required|string',

            ]);
            //->where('reqest_time',STR_TO_DATE($request->reqest_time,'%Y-%m-%d %H:%i:%s'))
        $trip = Trip::where('rider_id',$request->rider_id)
                        ->where('reqest_time', $request->reqest_time)
                        ->orderBy('reqest_time', 'asc')->limit(1)->get();
        if(count($trip)> 0){

            if($trip[0]->driver_id != null && $trip[0]->state === 'inprogress'){
                $this->driverUpdate($trip[0]->driver_id, true);
                $driver = Driver::find($trip[0]->driver_id);
                $this->push_notification( $driver->remember_token , 'تم إلغاء الرحلة', "trip canceled by client", 'cancel');
            }
            $trip[0]->state = 'canceled';
            $trip[0]->trip_end_time = Carbon::now() ;
            $trip[0]->save();
            return $this->returnSuccessMessage("trip canceled");
            }
            else{
                return $this->returnError('E003', 'the trip not exist');
            }
    }

    public function trips(Request $request)
    {
        $request->validate([
            'rider_id' =>'required',
            ]);
        $trip = DB::table('trips')->select([
            "trips.id",
            "trips.state",
            "trips.trip_type",
            "trips.start_loc_name",
            "trips.end_loc_name",
            "trips.reqest_time",
            "trips.trip_time",
            "trips.payment_type",
            "trips.cost",
            "driver.name",
            "driver.phone",
            "vechile.plate_number",
        ])
        ->leftJoin('driver', 'trips.driver_id', '=', 'driver.id')
        ->leftJoin('vechile', 'driver.current_vechile', '=', 'vechile.id')
        ->where('rider_id',$request->rider_id)
        ->where('trips.state','!=', 'rejected')
        ->orderBy('reqest_time', 'desc')
        ->paginate(10);
        if($trip){
            return $this->returnSuccessMessage($trip);
        }else{
            return $this->returnError('E003', 'there is no trips');
        }

    }

    public function category()
    {
        $categories = Category::select([
            'id',
            'category_name',
            'basic_price',
            'km_cost',
            'minute_cost',
            'reject_cost',
            'cancel_cost',
            'percentage_type',
            'fixed_percentage',
            'category_percent'
            ])->where('show_in_app', true)->get();

            return $this -> returnData('category' , $categories, 'vechile category');
    }
    public function get_trip_data(Request $request)
    {
        $request->validate([
            'trip_id' =>'required',
            ]);
        $trip = Trip::select(['id', 'state', 'driver_id'])->find($request->trip_id);
        if($trip !== null){
            if($trip->state == 'request'){
                return $this -> returnData('data' , $trip,'request');
            }
            else if($trip->state == 'inprogress'){
                $driver = Driver::select(['driver.id', 'driver.name' , 'driver.phone', 'vechile.plate_number', 'vechile.color', 'vechile.vechile_type'])
                    ->leftJoin('vechile', 'driver.current_vechile', '=', 'vechile.id')
                    ->where('driver.id', $trip->driver_id)->get() ;

                $trip->driver = $driver[0];
                return $this -> returnData('data' , $trip,'inprogress');
            }
            else if($trip->state == 'arrived'){
                $driver = Driver::select(['driver.id', 'driver.name' , 'driver.phone', 'vechile.plate_number', 'vechile.color', 'vechile.vechile_type'])
                    ->leftJoin('vechile', 'driver.current_vechile', '=', 'vechile.id')
                    ->where('driver.id', $trip->driver_id)->get() ;

                $trip->driver = $driver[0];
                return $this -> returnData('data' , $trip,'arrived');
            }
            else if($trip->state == 'pickedup'){
                $driver = Driver::select(['driver.id', 'driver.name' , 'driver.phone', 'vechile.plate_number', 'vechile.color', 'vechile.vechile_type'])
                    ->leftJoin('vechile', 'driver.current_vechile', '=', 'vechile.id')
                    ->where('driver.id', $trip->driver_id)->get() ;

                $trip->driver = $driver[0];
                return $this -> returnData('data' , $trip,'pickedup');
            }
            else if($trip->state == 'canceled'){
                return $this -> returnSuccessMessage('canceled');

            }
            else{
                return $this -> returnSuccessMessage('completed');
            }
        }
        else{
            return $this->returnError('E003', 'هذه الرحلة لم تعد متاحه');
        }
    }
}
