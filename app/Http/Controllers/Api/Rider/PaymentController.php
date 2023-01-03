<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    use GeneralTrait;
    
    public function payment(Request $request)
    {
        $request->validate([
            'trip_id' =>'required'
        ]);
        $trip = Trip::find($request->trip_id);
        if($trip->state === 'expiry'){

            return $trip;
        }
        else if($trip->state === 'cancel'){
            
        }
    }
}
