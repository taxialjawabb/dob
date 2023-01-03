<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Trip;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *      php artisan db:seed --class=TripSeeder   
     * 
     * @return void
     */
    public function run()
    {
        for ($i= 1; $i < 20; $i++) { 
            $trip = new Trip;
            $trip->rider_id = $i;
//            $trip->driver_id = ;
//            $trip->vechile_id = ;
            $trip->state = $i %2 == 0? "inprogress":"request" ;
            $trip->start_loc_latitude =24.47855430828033 ;
            $trip->start_loc_longtitude =  39.63642328057018;
            $trip->start_loc_name = Str::random(10);
            $trip->start_loc_zipcode =rand(42210,42754) ; ;
            $trip->start_loc_id =  rand(123,1234);;
            $trip->end_loc_latitude = 24.37855430828033 ;
            $trip->end_loc_longtitude = 39.60642328057018 ;
            $trip->end_loc_name = Str::random(10);
            $trip->end_loc_zipcode =rand(42210,42754) ; ;
            $trip->end_loc_id =  rand(123,1234);;
            $trip->reqest_time = Carbon::now() ;
 //           $trip->trip_start_time = ;
  //          $trip->trip_wait_time = ;
//            $trip->trip_end_time = '0:50';
//            $trip->rider_rate = ;
//            $trip->driver_rate = ;
            $trip->distance = 4.3;
            $trip->trip_time = Carbon::now()->toDateTimeString();
            $trip->save();
        }
    }
}
