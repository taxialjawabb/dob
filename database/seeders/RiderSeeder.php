<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rider;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
class RiderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *      php artisan db:seed --class=RiderSeeder
     * 
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 100; $i++) { 
            $rider = new Rider;
            $rider->name = Str::random(10);
            $rider->password = Hash::make('password');
       //     $rider->state = ;
            $rider->email = Str::random(10).'@gmail.com';
       //     $rider->email_verified_at = ;
            $rider->phone =  rand(100000, 10000000);
       //     $rider->phone_verified_at = ;
//            $rider->remember_token = ;
  //          $rider->created_at = ;
    //        $rider->updated_at = ;

            $rider->save();
        }
    }
}
