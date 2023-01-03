<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *      php artisan db:seed --class=AdminSeeder
     * 
     * @return void
     */
    public function run()
    {
        $admin = new Admin;
        $admin->name = 'emloyee';
        $admin->password =Hash::make('123456');        
        $admin->nationality = 'سعودى';
        $admin->ssd = '1122334455';
        $admin->date_join = Carbon::now();
        $admin->Employment_contract_expiration_date = Carbon::now();
        $admin->final_clearance_exity_date = Carbon::now();
        $admin->working_hours = 8;
        $admin->monthly_salary = 5000;
        $admin->roles = 1;
        $admin->state = 'active';
        $admin->add_by = '0';
        $admin->email = 'info@taxialjawabb.com';
        // $admin->email_verified_at = '';
        $admin->phone = '123123';
        // $admin->phone_verified_at = '';
        // $admin->remember_token = '';
        // $admin->created_at = '';
        // $admin->updated_at = '';

        $admin->save();

        $admin->attachRole('super_user');
    }
}
