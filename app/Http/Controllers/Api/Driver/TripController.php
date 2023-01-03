<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Vechile;
use App\Models\Rider;
use App\Models\Trip;
use Illuminate\Support\Facades\Auth;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TripController extends Controller
{
    use GeneralTrait;

    public function request(Request $request)
    {
        $request->validate([
            'trip_id'    => 'required',
            'driver_id'    => 'required',
            // 'driver_id'    => 'required',
            // 'response' => 'required|string|in:accept,reject',
            // 'reject_driver' => 'array',
            // 'total_cost' => 'required|numeric',
            // 'driver_cost' => 'required|numeric',
            // 'company_cost' => 'required|numeric',
            // 'cancel_cost' => 'required|numeric',
            // 'reject_cost' => 'required|numeric',
            // 'payment_percentage' => 'required|string',
        ]);
        $trip = Trip::find($request->trip_id);
        if($trip->state === "canceled"){
            return $this->returnError('E003', 'تم إلغاء هذه الرحلة من قبل العميل ');
        }
        else if($trip->state !== "request"){
            return $this->returnError('E003', 'هذه الرحلة لم تعد متاحة ');
        }

        //$driver = Auth::guard('driver-api') -> user() ;
        $driver = Driver::select(['driver.id', 'driver.name' , 'driver.phone', 'vechile.plate_number', 'vechile.color', 'vechile.vechile_type'])
                    ->leftJoin('vechile', 'driver.current_vechile', '=', 'vechile.id')
                    ->where('driver.id', $request->driver_id)->get() ;

        if(count($driver) === 0 ){
            return $this->returnError('E003', 'حدث خطاء الرجاء المحاولة فى وقت  لاحق . بعد تسجيل الخروج من التطبيق اولا ');
        }
        $trip->driver_id = $driver[0]->id;
        $trip->state = 'inprogress';
        $trip->save();
        //return $trip;
        $rider = Rider::select(['remember_token'])->find($trip->rider_id);
        //send notification to driver for new trip

        $trip->driver = $driver[0];
        $this->push_notification($rider->remember_token, 'السائق قادم فى الطريق', $trip, 'start');
        //return $this -> returnData('rider' , $rider,'start trip');
        return $this->returnSuccessMessage("تم قبول الرحلة بنجاح");

    }
    public function trips(Request $request)
    {
        $request->validate([
            'driver_id' =>'required',
            ]);
        $trip = Trip::where('driver_id',$request->driver_id)->paginate(15);
        if($trip){
            return $this->returnSuccessMessage($trip);
        }else{
            return $this->returnError('E003', 'trip not exist');
        }
    }
    public function available()
    {
        $token = request()->header('auth-token');
        if($token){
            try {
                $driverData = Auth::guard('driver-api') -> user();
                $driverData ->available = !$driverData->available ;
                $driverData->save();
        }catch(\Exception $ex){
                return  $this -> returnError('','some thing went wrongs');
            }
            return $this -> returnData('available' , $driverData->available,'driver state');
        }else{
            return $this->returnError('', 'some thing is wrongs');
        }
    }
    public function online()
    {
        $token = request()->header('auth-token');
        if($token){
            try {
                $driverData = Auth::guard('driver-api') -> user();
                $driverData ->available = 1 ;
                $driverData->save();
        }catch(\Exception $ex){
                return  $this -> returnError('','some thing went wrongs');
            }
            return $this -> returnData('available' , $driverData->available,'driver state');
        }else{
            return $this->returnError('', 'some thing is wrongs');
        }
    }
    public function offline()
    {
        $token = request()->header('auth-token');
        if($token){
            try {
                $driverData = Auth::guard('driver-api') -> user();
                $driverData ->available = 0 ;
                $driverData->save();
        }catch(\Exception $ex){
                return  $this -> returnError('','some thing went wrongs');
            }
            return $this -> returnData('available' , $driverData->available,'driver state');
        }else{
            return $this->returnError('', 'some thing is wrongs');
        }
    }
    public function location(Request $request)
    {
        $request->validate([
            "driver_id" =>"required|numeric",
            "current_loc_latitude" =>"required|numeric",
            "current_loc_longtitude" =>"required|numeric"
            ]);
            $driver = Driver::find($request->driver_id);
        if($driver !== null){
            try {
                $driver->current_loc_latitude = $request->current_loc_latitude;
                $driver->current_loc_longtitude = $request->current_loc_longtitude;
                $driver->save();
        }catch(\Exception $ex){
                return  $this -> returnError('','some thing went wrongs');
            }
            return $this->returnSuccessMessage("updated driver location");
        }else{
            return $this->returnError('', 'some thing is wrongs');
        }
    }

    public function trip_end(Request $request)
    {
        $request->validate([
            'trip_id' =>'required',
            ]);
        $trip = Trip::find($request->trip_id);
        if( $trip !== null){
            $trip->state = 'expired';
            $trip->trip_end_time = Carbon::now() ;
            $trip->save();
            return $this->returnSuccessMessage("the trip expired");
        }
        else{
            return $this->returnError('E003', 'the trip not exist');
        }
    }
    public function reject($trip_id, $driver_id, $reject_cost,Vechile $vechile  )
    {
        $trip = Trip::find($trip_id);
        if( $trip !== null){
            $trip->state = 'rejected';
            $trip->trip_end_time = Carbon::now() ;

            $driver = Driver::find($driver_id);
            if($driver !== null){
                $boxVechile = \App\Models\Vechile\BoxVechile::create([
                    'vechile_id' => $driver->current_vechile,
                    'foreign_type' => 'driver',
                    'foreign_id' => $driver->id,
                    'bond_type' => 'take',
                    'payment_type' => 'internal transfer',
                    'bond_state' => 'deposited',
                    'descrpition' => 'تم خصم مبلغ  ' .$reject_cost. ' عائد للمركبة رقم ' .$vechile->id .' على رحلة رقم ' .$trip->id ,
                    'money' => $reject_cost,
                    'tax' => 0,
                    'total_money' => $reject_cost,
                    'add_date' => Carbon::now(),
                ]);
                $driver->account   -=  $reject_cost;
                $vechile->account +=  $reject_cost;

                $trip->payment_type = 'internal transfer';
                $trip->cost =$reject_cost;

                $driver->available  =  1;

                $driver->save();
                $vechile->save();
                $message =  "تم خصم مبلغ  " .$reject_cost . " من حسابك لرفض الرحلة";
                $this->push_notification( $driver->remember_token , 'تم الخصم من الرصيد',$message, 'discount');

            }

            $trip->save();
            return $this->returnSuccessMessage("trip canceled");

        }
        else{
            return $this->returnError('E003', 'the trip not exist');
        }
    }

    public function driver_send_notification(Request $request)
    {
        $request->validate([
            "trip_id" =>"required"
            ]);

        $trip = Trip::find($request->trip_id);
        if($trip !== null){
            if($trip->state == 'canceled'){
                return $this->returnError('E004', 'لقد تم الغاء هذه الرحلة');
            }
            $trip->state = 'arrived';
            $trip->save();
            $rider = Rider::find($trip->rider_id);

            $this->push_notification($rider->remember_token, 'وصول السائق', 'وصل السائق و بداية الرحلة', 'pickedup');

            return $this->returnSuccessMessage("picked up successfully");
        }
        else{
            return $this->returnError('E003', 'هذه  الرحلة غير متاحة');
        }
    }
    public function rider_picked(Request $request)
    {
        $request->validate([
            "trip_id" =>"required"
            ]);

        $trip = Trip::find($request->trip_id);
        if($trip !== null){
            if($trip->state == 'canceled'){
                return $this->returnError('E004', 'لقد تم الغاء هذه الرحلة');
            }
            $trip->state = 'pickedup';
            $trip->save();
            $rider = Rider::find($trip->rider_id);

            $this->push_notification($rider->remember_token, 'بداء الرحلة ', 'لقد بداء الرحلة مرحبا ', 'riderpicked');
            return $this->returnSuccessMessage("picked up successfully");
        }
        else{
            return $this->returnError('E003', 'هذه  الرحلة غير متاحة');
        }
    }
    public function show_intrnal_trip_to_driver(Request $request)
    {
        $request->validate([
            'current_vechile'    => 'required'
        ]);
        $data = Trip::select([
             'trips.id as idTrip',
             'trips.state',
             'trips.vechile_id',
             'trips.trip_type',
             'trips.start_loc_name',
             'trips.start_loc_latitude',
             'trips.start_loc_longtitude',
             'trips.end_loc_name',
             'trips.end_loc_latitude',
             'trips.end_loc_longtitude',
             'trips.reqest_time',
             'trips.trip_time',
             'trips.cost',
             'category.basic_price',
             'category.km_cost',
             'category.minute_cost',
             'secondary_category.percentage_type as percentage_type',
             'secondary_category.category_percent as category_percent',
             'rider.id as rider_id',
             'rider.phone',
             'rider.name'
        ])
        ->leftJoin('category', 'trips.vechile_id', '=', 'category.id')
        ->leftJoin('vechile', 'vechile.category_id', '=', 'category.id')
        ->leftJoin('secondary_category', 'vechile.secondary_id', '=', 'secondary_category.id')
        ->leftJoin('rider', 'rider.id', '=', 'trips.rider_id')
        ->where("trips.trip_type", 'internal')->where("trips.state", 'request')
        ->where('vechile.id', $request->current_vechile)->get();
        ;
        // $data = DB::select("select
        // trips.id as idTrip,
        // trips.state,
        // trips.vechile_id,
        // trips.trip_type,
        // trips.start_loc_name,
        // trips.start_loc_latitude,
        // trips.start_loc_longtitude,
        // trips.end_loc_name,
        // trips.end_loc_latitude,
        // trips.end_loc_longtitude,
        // trips.reqest_time,
        // trips.trip_time ,
        // trips.cost ,
        // category.basic_price,
        // category.km_cost,
        // category.minute_cost,
        // secondary_category.percentage_type as percentage_type,
        // secondary_category.category_percent as category_percent,
        // rider.id as rider_id,
        // rider.phone,
        // rider.name
        // from trips , vechile, category , rider ,secondary_category
        // where rider.id= trips.rider_id and  trips.vechile_id= category.id and vechile.category_id = category.id and  vechile.secondary_id  =secondary_category.id
        // and trips.trip_type ='internal' and trips.state='request' and vechile.id = ? ", [$request->current_vechile]);

        return $this -> returnData('data' , $data, ' trips');

    }

    public function start_trip_city(Request $request)
    {
        $request->validate([
            'trip_id'    => 'required',
        ]);
        $trip = Trip::find($request->trip_id);

        if($trip !== null){
            $trip->trip_start_time = Carbon::now();
            $trip->save();
            return $this->returnSuccessMessage("تم بدء الرحلة");
        }
        else{
            return $this->returnError('E003', 'خطاء هذه الرحلة غير متاحة');
        }
    }
    public function end_trip_city(Request $request)
    {
        $request->validate([
            'trip_id'    => 'required',
        ]);
        $trip = Trip::find($request->trip_id);

        if($trip !== null){
            $trip->trip_end_time = Carbon::now();
            $trip->state = 'expired';
            $trip->save();
            return $this->returnSuccessMessage("تم انهاء الرحلة");
        }
        else{
            return $this->returnError('E003', 'خطاء هذه الرحلة غير متاحة');
        }
    }

    public function request_created_by_driver(Request $request)
    {
        $request->validate([
            'driver_id' =>'required|numeric',
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
            'trip_time' =>'required'
            ]);

            $driver = Driver::find($request->driver_id);

            if($driver !== null){
                $vehcile = Vechile::find($driver->current_vechile);
                if($vechile !== null){

                    $data = App\Models\Trip::create([

                    ]);
                    return $this -> returnData('data' , $data,'تم حفظ طلبك قيد الانتظار');
                }
                else{
                    return $this->returnError('E002', 'حدث خطاء فى بيانات المركبة  الرجاء المحاولة فى وقت لاحق');
                }
            }
            else{
                return $this->returnError('E001', 'حدث خطاء فى بيانات السائق الرجاء المحاولة فى وقت لاحق');
            }
    }
}
