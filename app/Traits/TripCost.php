<?php

namespace App\Traits;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\GeneralTrait;
use App\Models\Rider;
use App\Models\Driver;
use App\Models\Driver\BoxDriver;
use App\Models\Rider\BoxRider;
use App\Models\Vechile\BoxVechile;

trait TripCost
{
    public function calculate_trip_cost( $category_id, $distance)
    {
        
        $category = DB::select("select basic_price, km_cost, reject_cost, cancel_cost, percentage_type, fixed_percentage, category_percent from  category where id = ? limit 1;", [$category_id]);
        if(count($category) > 0){   
            $total =$category[0]->basic_price + ($category[0]->km_cost * ($distance /1000));
            $company = 0;
            $driver = 0;
            if($category[0]->percentage_type == "daily_percent" || $category[0]->percentage_type == "percent"){
                $company = $total * ($category[0]->category_percent /100);
                $driver = $total - $company;
            }
            return $this->tripCost($total , $driver , $company, $category[0]->cancel_cost, $category[0]->reject_cost , $category[0]->percentage_type);
        }
    }
    

    public function tripCost($total = 0 , $driver = 0, $company = 0, $cancel = 0, $reject = 0 , $payment_percentage = '')
    {
        $object = (object) [
                'total_cost' => $total,
                'driver_cost' => $driver,
                'company_cost' => $company,
                'cancel_cost' => $cancel,
                'reject_cost' => $reject,
                'payment_percentage' => $payment_percentage,
            ];
        return $object;
        
    }
}