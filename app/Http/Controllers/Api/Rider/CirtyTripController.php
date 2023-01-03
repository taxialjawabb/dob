<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rider;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Traits\GeneralTrait;
use App\Models\Rider\BoxRider;
use App\Models\Trip;
use App\Models\Driver;
use App\Models\Vechile;
use App\Models\City;
use App\Models\Driver\BoxDriver;
use App\Models\Vechile\BoxVechile;

class CirtyTripController extends Controller
{
    use GeneralTrait;
    public function city_request(Request $request)
    {
        $request->validate([
            'rider_id' =>'required',
            'category_id' =>'required',
            'going_cost' =>'required|string|in:going_cost,going_back_cost',
            'city_id' =>'required',
            'start_loc_latitude' =>'required|numeric',
            'start_loc_longtitude' =>'required|numeric',
            'start_loc_name' =>'required|string',
            'start_loc_id' =>'required',
            'reqest_time' =>'required'
            ]);                                     
            $city = DB::select(" select  city.id , city.city, city.going_cost, city.going_back_cost, city.city_cancel_cost , city.city_regect_cost, city.percentage_type, city.city_percent
                                from  city where city.id= ? and category_id =  ? limit 1 ;" , [$request->city_id, $request-> category_id]);
            $rider = Rider::find($request->rider_id);
            if(count($city)> 0 && $rider !== null){
                $total_cost = 0;
                if($request->going_cost == 'going_cost'){
                    $total_cost = $city[0]->going_cost;
                }else if($request->going_cost == 'going_back_cost'){
                    $total_cost = $city[0]->going_back_cost;
                }
                if($rider->account >= $total_cost && $total_cost > 0){
                    $trip = $this->insertTrip($request, $city[0]->id, $city[0]->city);
                    
                    $boxRider = new boxRider;
                    
                    $boxRider->rider_id = $rider->id;
                    $boxRider->bond_type = 'spend';
                    $boxRider->payment_type = 'internal transfer';
                    $boxRider->bond_state = 'deposited';
                    $boxRider->money = $total_cost;
                    $boxRider->tax = 0;
                    $boxRider->total_money = $total_cost;
                    $boxRider->descrpition =  'تم خصم مبلغ  ' .$total_cost .' لحجز رحلة بين المدن من المدينة ألى '. $request->city_id;
                    $boxRider->add_date = Carbon::now();
                    //$BoxRider->add_by = Auth::guard('admin')->user()->id;
            
                    $rider->account -=  $total_cost;
                    
                    $trip->payment_type = 'internal transfer';
                    $trip->cost =$total_cost;
                    $trip->save();
                    $boxRider->save();
                    $rider->save();
                    $rider->trip_city_cost = $total_cost;
                    
                    $this->push_notification($rider->remember_token, 'تم الخصم من الرصيد', $rider,'city_payment');
                    return $this -> returnData('data' , $trip, 'city trip saved successfully');   
                }
                
                return $this->returnError('E001',"لا يوجد رصيد كافى ");
            }
            else{
                return $this->returnError('E001',"هذا التصنيف لا يحتوى على رحلات للمدينة المحددة");
            }


    }

    private function insertTrip($request , $secondary_category, $city_name)
    {
        $trip = new Trip;
        
        $trip->state = 'request' ;
        $trip->trip_type = 'city';
        $trip->rider_id = $request->rider_id;
        $trip->vechile_id	 = $secondary_category;
        $trip->start_loc_latitude = number_format($request->start_loc_latitude, 15, '.', ',') ;
        $trip->start_loc_longtitude = number_format($request->start_loc_longtitude, 15, '.', ',') ;
        $trip->start_loc_name = $request->start_loc_name;
        $trip->end_loc_name = $city_name;
        $trip->start_loc_id = $request->start_loc_id;
        $trip->reqest_time =  $request->reqest_time;
        if($request->has('trip_time')){
            $trip->trip_time = $request->trip_time;
        }
    

        $trip->save();
        return $trip;
    } 
    public function city_category()
    {
        $data = DB::select(' select category.id as categoryId, category.category_name,
                    city.id as cityId, city.city, city.going_cost, city.going_back_cost, city.city_cancel_cost 
                    from category , city where category.id = city.category_id and category.show_in_app = true order by categoryId ;');
        
        return $this -> returnData('data' , $data, 'city');   
        
    }

    public function driver_response(Request $request)
    {
        $request->validate([
            'trip_id'    => 'required',
            'driver_id'    => 'required'
        ]);
        $trip = Trip::find($request->trip_id);
        $driver = Driver::find($request->driver_id);
        if($trip !== null && $driver !== null){
            $vechile = Vechile::find($driver->current_vechile);
            if($trip->state === "request" && $trip->trip_type === 'city'){
                $city = City::find($trip->vechile_id);
                if($city !== null){
                    $driver_cost = 0;
                    $campany_cost = 0;
                    if($city->percentage_type === 'fixed'){
                        $campany_cost = $city->city_percent;
                        $driver_cost = $trip->cost - $campany_cost;
                    }
                    else if($city->percentage_type === 'percent'){
                        $campany_cost =  $trip->cost * ($city->city_percent/100);
                        $driver_cost = $trip->cost - $campany_cost;
                    }
                    $boxDriver =  new BoxDriver();
                    $boxVechile = new BoxVechile();

                    $boxVechile->vechile_id = $vechile->id;
                    $boxVechile->foreign_type = 'rider';
                    $boxVechile->foreign_id = $trip->rider_id;
                    $boxVechile->bond_type = 'take';
                    $boxVechile->payment_type = 'internal transfer';
                    $boxVechile->bond_state = 'deposited';
                    $boxVechile->descrpition = 'تم خصم مبلغ  ' .$campany_cost. ' عائد للمركبة رقم ' .$vechile->id .' على رحلة رقم ' .$request->trip_id .' تكلفة الرحلة ' .$request->cost ;
                    $boxVechile->money = $campany_cost * 0.8;
                    $boxVechile->tax = 0;
                    $boxVechile->total_money = $campany_cost * 0.8;
                    $boxVechile->add_date = Carbon::now();

                    $boxVechileAds = new BoxVechile();
                    $boxVechileAds->vechile_id = $vechile->id;
                    $boxVechileAds->foreign_type = 'stakeholders';
                    $boxVechileAds->foreign_id = 11;
                    $boxVechileAds->bond_type = 'spend';
                    $boxVechileAds->payment_type = 'internal transfer';
                    $boxVechileAds->bond_state = 'deposited';
                    $boxVechileAds->descrpition =  'عائد من رحلة إلى أدارة التسويق والدعاية من رحلة بين المدن';
                    $boxVechileAds->money = $campany_cost * 0.2;
                    $boxVechileAds->tax = 0;
                    $boxVechileAds->total_money = $campany_cost * 0.2;
                    $boxVechileAds->add_date = Carbon::now();
                    $boxVechileAds->save();
                    $stakeholder = \App\Models\Nathiraat\Stakeholders::find(11);
                    $stakeholder-> account += $campany_cost * 0.2;
                    $stakeholder->save();

                    $boxDriver->driver_id = $driver->id;
                    $boxDriver->bond_type = "take";
                    $boxDriver->payment_type = 'internal transfer';
                    $boxDriver->bond_state = 'deposited';
                    $boxDriver->money = $driver_cost;
                    $boxDriver->tax = 0;
                    $boxDriver->total_money = $driver_cost;
                    $boxDriver->descrpition =   'تم أضافة مبلغ  ' .$driver_cost. '   رحلة بين المدن الى '. $city->city.' رحلة رقم ' .$request->trip_id ;
                    $boxDriver->add_date = Carbon::now();
                    
                    $driver->account +=  $driver_cost;
                    $vechile->account +=  $campany_cost * 0.8;
                    
                    
                    $trip->driver_id = $driver->id;
                    $trip->state = 'inprogress' ;
                    $trip->save();
                    
                    $boxDriver->save();
                    $boxVechile->save();

                    $driver->save();
                    $vechile->save();

                    $this->push_notification($driver->remember_token, 'تم إضافة إلى الرصيد', 'تم أضافة مبلغ  ' .($driver_cost). ' إلى رصيدك  ', 'payment');
                    return $this->returnData("Payment confirmed successfully","Payment confirmed successfully");
                }
            }
            else{
                return $this->returnError('100016',"هذا الرحلة لم تعد متاحة ");
            }
        }
        else{
            return $this->returnError('100016',"حدث خطاء هذه الرحلة لم تعد متاحة ");
        }
    }

    public function rider_canceled_trip(Request $request)
    {
        $request->validate([
            'trip_id'    => 'required'
        ]);
        
        $trip = Trip::find($request->trip_id);
        if($trip !== null){
            if($trip->state === "canceled" || $trip->state === "rejected" ||$trip->state === "expired" ){
                return $this->returnError('E001',"هذا الرحلة لم تعد متاحة ");
            }
            
                
            
            $rider = Rider::find($trip->rider_id);
            
            $diff = Carbon::now()->diff($trip->reqest_time)->format('%H:%I:%S');
            $boolen = strtotime($diff)>strtotime('6:0:01')? 'true' : 'false';
            $city = City::find($trip->vechile_id);

                
            $driver_cost = 0;
            $campany_cost = 0;
            if($city !== null ){
                if($city->percentage_type === 'fixed'){
                    $campany_cost = $city->city_percent;
                    $driver_cost = $trip->cost - $campany_cost;
                }
                else if($city->percentage_type === 'percent'){
                    $campany_cost =  $trip->cost * ($city->city_percent/100);
                    $driver_cost = $trip->cost - $campany_cost;
                }
            }
            // discount from rider 
            if($boolen){
                //if driver accept  return money that goes to driver 
                if($trip->driver_id !== null){
                    $driver = Driver::find($trip->driver_id);
                    $this->driver_bond($driver, $driver_cost );
                    // return rider money
                    $this->rider_bond($rider , $driver_cost );
                }
                // if no driver accept cost cancel cost and reject
                else{
                    $this->rider_bond($rider , $city->city_cancel_cost );
                }
                $trip->state = 'canceled';
                $trip->trip_end_time = Carbon::now() ;
                $trip->save();
               return $this->returnSuccessMessage('تم إلغاء الرحلة بنجاح');
           
            }
            // No discount from rider 
            else{
                // return rider the holl money
                $this->rider_bond($rider , $trip->cost );
                // if no driver accept no cancel cost return all money
                if($trip->driver_id !== null){
                    //if driver accept  return money that goes to driver and campany cost
                    $driver = Driver::find($trip->driver_id);
                    $this->driver_bond($driver, $driver_cost );
                    $vechile = Vechile::find($driver->current_vechile);
                    $this->driver_bond($vechile, $campany_cost );

                }               
            }
            $trip->state = 'canceled';
            $trip->trip_end_time = Carbon::now() ;
            $trip->save();
            return $this->returnSuccessMessage('تم إلغاء الرحلة بنجاح');
        }
        else{
            return $this->returnError('E001',"هذا الرحلة لم تعد متاحة ");
        }
    }
    private function rider_bond(Rider $rider, $total_cost )
    {
        $boxRider = new BoxRider();
        $boxRider->rider_id = $rider->id;
        $boxRider->bond_type = 'take';
        $boxRider->payment_type = 'internal transfer';
        $boxRider->money = $total_cost;
        $boxRider->tax = 0;
        $boxRider->total_money = $total_cost;
        $boxRider->descrpition =  'تم استرداد مبلغ  ' .$total_cost .'  لإلغاء حجز رحلة بين المدن من المدينة ألى ';
        $boxRider->add_date = Carbon::now();
        
        $rider->account +=  $total_cost;
        
        $boxRider->save();
        $rider->save();
    }
    private function driver_bond(Driver $driver,  $total_cost )
    {
        $boxDriver = new BoxDriver();
        $boxDriver->driver_id = $driver->id;
        $boxDriver->bond_type = 'spend';
        $boxDriver->payment_type = 'internal transfer';
        $boxDriver->bond_state = 'deposited';
        $boxDriver->money = $total_cost;
        $boxDriver->tax = 0;
        $boxDriver->total_money = $total_cost;
        $boxDriver->descrpition =  'تم خصم مبلغ  ' .$total_cost .'  لإلغاء حجز رحلة بين المدن من المدينة ألى ';
        $boxDriver->add_date = Carbon::now();
        
        $driver->account -=  $total_cost;
        
        $boxDriver->save();
        $driver->save();
    }
    private function vechile_bond(Vechile $vechile, $total_cost )
    {
        $boxVechile = new  BoxVechile();
        $boxVechile->driver_id = $vechile->id;
        $boxVechile->bond_type = 'spend';
        $boxVechile->payment_type = 'internal transfer';
        $boxVechile->bond_state = 'deposited';
        $boxVechile->money = $total_cost;
        $boxVechile->tax = 0;
        $boxVechile->total_money = $total_cost;
        $boxVechile->descrpition =  'تم خصم مبلغ  ' .$total_cost .'  لإلغاء حجز رحلة بين المدن من المدينة ألى ';
        $boxVechile->add_date = Carbon::now();
        
        $vechile->account -=  $total_cost;
        
        $boxVechile->save();
        $vechile->save();
    }


    public function show_city_trip_to_driver(Request $request)
    {
        $request->validate([
            'current_vechile'    => 'required'
        ]);

        $data = DB::select("select 
      
     
        CONVERT(trips.id, CHAR) as id,
        trips.state, 
        trips.trip_type, 
        trips.start_loc_name, 
        trips.start_loc_latitude,
        trips.start_loc_longtitude,
        trips.end_loc_name, 
        trips.reqest_time, 
        trips.trip_time ,
        trips.payment_type, 
        CONVERT(trips.cost, CHAR(20)) as cost, 
        city.city
        from trips , vechile, city 
        where  trips.vechile_id= city.id and vechile.category_id = city.category_id 
        and trips.trip_type ='city' and trips.state='request' and vechile.id = ?", [$request->current_vechile]);

        return $this -> returnData($data, 'city trips');   
        
    }
}
