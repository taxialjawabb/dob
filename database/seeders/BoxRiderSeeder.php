<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BoxRider;
use Illuminate\Support\Str;
use Carbon\Carbon;
class BoxRiderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *      php artisan db:seed --class=BoxRiderSeeder
     * 
     * 
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 2 ; $i++) { 
            $boxRider = new BoxRider;
            $boxRider->rider_id = 1;
            $boxRider->bond_type = $i %2 ==0 ? 'spend' : 'take';
            $boxRider->payment_type = "cash";
            $boxRider->money = 25;
            $boxRider->tax = 5;
            $boxRider->total_money = 30;
            $boxRider->descrpition = Str::random(10);
            $boxRider->add_date = Carbon::now();
            $boxRider->add_by = 1;
            $boxRider->bond_state = 'waiting';

            $boxRider->save();
        }
    }
}
