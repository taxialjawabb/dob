<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Driver;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *      php artisan db:seed --class=DriverSeeder
     * 
     * @return void
     */
    public function run()
    {
        for($i = 1 ; $i < 100 ; $i++){
            $driver = new Driver;
            $driver->name= Str::random(10);
            $driver->password= Hash::make('password');
            $driver->available= $i %2 == 0? 0:1;
            $driver->nationality= Str::random(10);
            $driver->ssd= rand(10000,20000);
            $driver->id_copy_no= rand(10000,20000);
            $driver->id_expiration_date= Carbon::now();
            $driver->license_type= 'private';
            $driver->license_expiration_date = Carbon::now();
            $driver->birth_date= Carbon::now();
            $driver->start_working_date=Carbon::now() ;
            $driver->contract_end_date= Carbon::now();
            $driver->final_clearance_date= Carbon::now();
            $driver->persnol_photo= Str::random(10);
            $driver->address= Str::random(10);
            $driver->current_vechile= $i;
            $driver->add_date = Carbon::now();
            $driver->admin_id= 1;
            //$driver->state= 'active';
            $driver->email= Str::random(10).'@gmail.com';
            //$driver->email_verified_at= ;
            $driver->phone= rand(123123,123123212);
            //$driver->phone_verified_at= ;
            //$driver->remember_token= ;
            //$driver->created_at= ;
            //$driver->updated_at= ;
            $driver->current_loc_latitude= 24.470594383769644 + ($i /200);
            $driver->current_loc_longtitude= 39.61087253690272 + ($i /200);
            $driver->current_loc_name= Str::random(10).'@gmail.com';
            $driver->current_loc_zipcode= rand(42210,42754) ;
            $driver->current_loc_id= rand(123,1234);

            $driver->save();
        }
    }
}
