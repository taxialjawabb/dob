<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CatogreySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i < 3 ; $i++) { 
            $cat = new Category;
            $cat->id = $i;
            $cat->category_name = $i % 2 ==0 ? 'family' :  'private';
            $cat->basic_price = 10 * $i;
            $cat->km_cost =  $i * 2;
            $cat->reject_cost = $i * 5;
            $cat->cancel_cost = $i * 3;
            $cat->daily_revenue_cost = 50 * $i;
            $cat->percentage_type = 'fixed';
            $cat->fixed_percentage = 100;
            $cat->category_percent = 15;
            $cat->admin_id = 1;
            $cat->save();
        }
    }
}
