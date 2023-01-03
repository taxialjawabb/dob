<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BookingController extends Controller
{
    
    public function requestsBooking(Request $request)
    {
        $state =$request->request_state;
        if($state=='expired')
        {

            $bookings = DB::select("
                select booking.id, ROUND(booking.price, 2) as price,  DATEDIFF(booking.end_date , booking.start_date) as days,
                rider.name as rider_name , rider.phone as rider_phone , driver.name as driver_name, driver.phone as driver_phone
                from booking  left join rider on booking.rider_id = rider.id
                left join driver on booking.driver_id = driver.id
                where booking.state= ? and booking.end_date < ?
            ", [$state,Carbon::now()]);
            return view('booking.bookings', compact('bookings', 'state'));

        }
        else
        {
        $bookings = DB::select("
                select booking.id, ROUND(booking.price, 2) as price,  DATEDIFF(booking.end_date , booking.start_date) + 1 as days,
                rider.name as rider_name , rider.phone as rider_phone , driver.name as driver_name, driver.phone as driver_phone
                from booking  left join rider on booking.rider_id = rider.id
                left join driver on booking.driver_id = driver.id
                where booking.state= ?
        ", [$state]);
        return view('booking.bookings', compact('bookings', 'state'));
}
    }

    public function save_discount(Request $request)
    {
        $request->validate([            
            'trip_count' =>     'required|integer',
            'discount' =>          'required|numeric',
        ]);
        $discount = \App\Models\Booking\BookingDiscount::create([
                'percentage_to' => $request->trip_count,
                'percentage' => $request->discount,
        ]);
        $request->session()->flash('status', 'تم إضافة نسبة الخصم بنجاح');
        return back();
    }
    public function save_update(Request $request)
    {
        $request->validate([            
            'discount_id' =>  'required|integer',
            'trip_count' =>   'required|integer',
            'discount' =>     'required|numeric',
        ]);
        $discount = \App\Models\Booking\BookingDiscount::find($request->discount_id);
        if($discount !== null){
            $discount->id  =$request->discount_id ;
            $discount->percentage_to  =$request->trip_count ;
            $discount->percentage  =$request->discount ;
            $discount->save();

            $request->session()->flash('status', 'تم إضافة نسبة الخصم بنجاح');
        }else{
            $request->session()->flash('error', 'خطاء فى البيانات الرجاء المحاولة فى وقت لاحق');
        }
        return back();
    }
    public function show_discount()
    {
        $data = \App\Models\Booking\BookingDiscount::all();
        return view('booking.showDiscountBookings', compact('data'));
    }
}
