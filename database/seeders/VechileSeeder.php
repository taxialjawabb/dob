<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vechile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VechileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     *      php artisan db:seed --class=VechileSeeder
     *
     * @return void
     */
    public function run()
    {
        for ($i= 1; $i < 200; $i++) { 
            $vechile = new Vechile;
            $vechile->vechile_type = $i % 2 == 0? 'BMW': 'Toyota' ;
            $vechile->made_in = '20' . rand(16,21);
            $vechile->serial_number = rand(1000,2000);
            $vechile->plate_number = rand(1000,2000);
            $vechile->color = $i %2 ==0? 'White': 'Green' ;
            $vechile->driving_license_expiration_date = Carbon::now();
            $vechile->insurance_card_expiration_date = Carbon::now();
            $vechile->periodic_examination_expiration_date = Carbon::now();
            $vechile->operating_card_expiry_date = Carbon::now();
            $vechile->add_date = Carbon::now();
            //$vechile->state = 'active';
            $vechile->admin_id = 1 ;
            $vechile->category_id = 1;
           

            $vechile->save();
        }
    }
}
