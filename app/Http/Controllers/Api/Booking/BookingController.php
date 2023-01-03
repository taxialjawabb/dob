<?php

namespace App\Http\Controllers\Api\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use App\Models\Rider\BoxRider;
use App\Models\SecondaryCategory;
use App\Models\Vechile\BoxVechile;

class BookingController extends Controller
{
    use GeneralTrait;
    public function booking_trip(Request $request)
    {
        
        $request->validate([
            'rider_id'   => 'required|string',
            'price'    => 'required|numeric',
            'start_loc_latitude'    => 'required|numeric',
            'start_loc_longtitude'    => 'required|numeric',
            'start_loc_name'   => 'required|string',
            'end_loc_latitude'    => 'required|numeric',
            'end_loc_longtitude'    => 'required|numeric',
            'end_loc_name'   => 'required|string',
            'distance'   => 'required|numeric',
            'trip_time'   => 'required|string',
            'going_time'   => 'required|string',
            'back_time'   => 'required|string',
            'has_return'   => 'required|boolean',
            'list_date'   => 'required|string',
            'start_date' => 'required|string',
            'end_date' => 'required|string',            
            'category_id' => 'required|string'
        ]);
        
        $rider = \App\Models\Rider::find($request->rider_id);
        if($rider === null){
            return $this->returnError('E001',"حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
        else if($rider->account < $request->price){
            return $this->returnError('E002',"عفوا لا يوجد رصيد كافى");
        }

        $requestData=$request->only([
            'start_date',
            'end_date',
            'start_loc_latitude',
            'start_loc_longtitude',
            'start_loc_name',
            'end_loc_latitude',
            'end_loc_longtitude',
            'end_loc_name',
            'distance',
            'trip_time',
            'has_return',
            'going_time',
            'back_time',
            'list_date',
            'rider_id',
            'driver_id',
            'price',
            'category_id'
        ]);
        $requestData['state']="pending";

        $booking = \App\Models\Booking\Booking::create($requestData);

        $boxRider = new BoxRider();            
        $boxRider->rider_id = $rider->id;
        $boxRider->bond_type = 'spend';
        $boxRider->payment_type = 'internal transfer';
        $boxRider->bond_state = 'deposited';
        $boxRider->money = $request->price;
        $boxRider->tax = 0;
        $boxRider->total_money = $request->price;
        $boxRider->descrpition =  'تم خصم مبلغ '. $request->price .' للإشتراك فى خدمة توصيل من الفترة '. $request->start_date .' إلى الفترة' . $request->end_date .'إشتراك رقم '. $booking->id;
        $boxRider->add_date = \Carbon\Carbon::now();

        $rider->account -=  $request->price;
        $boxRider->save();
        $rider->save();

        return $this -> returnData('data' , $booking,  $boxRider->descrpition);  
    }
    public function category()
    {
        $categories = \App\Models\Category::select([
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

            $bookingDiscount = \App\Models\Booking\BookingDiscount::select(['percentage_to', 'percentage'])
                                ->orderBy('percentage_to')->get();
            $array = [
                        'category' => $categories, 
                        'discount' => $bookingDiscount
                    ];

            return $this -> returnData('booking' , $array, 'booking category and discount');
    }

    public function show_mybooks(Request $request)
    {
        $request->validate([
            'rider_id'   => 'required|string',
        ]);
        $rider = \App\Models\Rider::find($request->rider_id);
        if($rider !== null){
            $data =  \App\Models\Booking\Booking::where('rider_id'  , $rider->id )
                                                        ->where('state' , 'active')
                                                        ->orWhere('state' , 'pending')
                                                    ->with('driver:id,name,phone')->paginate(10);
            return $this->returnData('data' , $data, "show rider's books by id");
        }
        else{
            return $this->returnError('E001',"حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
    }
    public function cancel_booking(Request $request)
    {
        $request->validate([
            'rider_id'   => 'required|string',
            'book_id'   => 'required|string',
        ]);
        $rider = \App\Models\Rider::find($request->rider_id);
        $booking = \App\Models\Booking\Booking::find($request->book_id);

        if($rider !== null && $booking !== null){
            
            // return  \Carbon\Carbon::parse($booking->start_date)->format('Y-m-d')."======". \Carbon\Carbon::now()->format('Y-m-d');

            if(\Carbon\Carbon::parse($booking->start_date)->format('Y-m-d') < \Carbon\Carbon::now()->format('Y-m-d')){
                return $this->returnError('E002',"لم يعد بأمكان إلغاء هذه الرحلة ");
            }
            if($booking->state === 'canceled'){
                return $this->returnError('E003',"تم إلغاء  هذه الرحلة من قبل");
            }
            if($booking->driver === null){

                $boxRider = new BoxRider();            
                $boxRider->rider_id = $rider->id;
                $boxRider->bond_type = 'take';
                $boxRider->payment_type = 'internal transfer';
                $boxRider->bond_state = 'deposited';
                $boxRider->money = $booking->price;
                $boxRider->tax = 0;
                $boxRider->total_money = $booking->price;
                $boxRider->descrpition =  'تم استرجاع مبلغ '. $booking->price .'لإلغاء الإشتراك فى خدمة توصيل من الفترة '. $booking->start_date .' إلى الفترة' . $booking->end_date .'إشتراك رقم '. $booking->id;
                $boxRider->add_date = \Carbon\Carbon::now();
                
                $rider->account +=  $booking->price;
                $boxRider->save();
                $rider->save();

                $booking->state = 'canceled';
                $booking->save();
                return $this->returnSuccessMessage("تم إلغاء الإشتراك بنجاح ");

            }
            else{
                $driver  = \App\Models\Driver::find($booking->driver_id);
                $vechile = \App\Models\Vechile::find($driver->current_vechile);
                if($driver !== null && $vechile !== null){
                    $secondaryCategory = SecondaryCategory::find($vechile->secondary_id);
                    if($secondaryCategory === null){
                        return $this->returnError('E001',"الرجاء الرجوع للشركة لمراجعت بياناتك");
                    }
                    $campany_cost = 0;
                    $driver_cost = 0;
                    if($secondaryCategory->percentage_type == 'fixed'){
                        $campany_cost =  $secondaryCategory->category_percent;
                        $driver_cost =  $booking->price - $campany_cost;
                    }
                    else if($secondaryCategory->percentage_type == 'percent'){
                        $campany_cost =  ($booking->price * ($secondaryCategory->category_percent /100));
                        $driver_cost = $booking->price -  $campany_cost;
                    }

                    $boxRider = new BoxRider();            
                    $boxRider->rider_id = $rider->id;
                    $boxRider->bond_type = 'take';
                    $boxRider->payment_type = 'internal transfer';
                    $boxRider->bond_state = 'deposited';
                    $boxRider->money = $driver_cost;
                    $boxRider->tax = 0;
                    $boxRider->total_money = $driver_cost;
                    $boxRider->descrpition =  'تم استرجاع مبلغ '. $driver_cost .'لإلغاء الإشتراك فى خدمة توصيل من الفترة '. $booking->start_date .' إلى الفترة' . $booking->end_date .'إشتراك رقم '. $booking->id;
                    $boxRider->add_date = \Carbon\Carbon::now();
                    
                    $boxVechile1 = new BoxVechile();
                    $boxVechile1->vechile_id = $vechile->id;
                    $boxVechile1->foreign_type = 'driver';
                    $boxVechile1->foreign_id = $driver->id;
                    $boxVechile1->bond_type = 'take';
                    $boxVechile1->payment_type = 'internal transfer';
                    $boxVechile1->bond_state = 'deposited';
                    $boxVechile1->descrpition =  'تم خصم مبلغ '. $driver_cost .'لإلغاء الإشتراك فى خدمة توصيل من الفترة '. $booking->start_date .' إلى الفترة' . $booking->end_date .'إشتراك رقم '. $booking->id;
                    $boxVechile1->money = $campany_cost;
                    $boxVechile1->tax = 0;
                    $boxVechile1->total_money = $campany_cost;
                    $boxVechile1->add_date = \Carbon\Carbon::now();

                    $rider->account +=  $driver_cost;
                    $driver->account -=  $driver_cost;
                    $boxRider->save();
                    $boxVechile1->save();
                    $rider->save();
    
                    $booking->state = 'canceled';
                    $booking->save();


                    return $this->returnSuccessMessage("تم إلغاء الإشتراك بنجاح ");
                }else{
                    return $this->returnError('E002',"حدث خطاء فى بيانات الإشتراك");
                }
                
            }
        }
        else{
            return $this->returnError('E001',"حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
    }
}
