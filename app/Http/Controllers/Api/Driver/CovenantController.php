<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Covenant\CovenantItem;
use App\Traits\GeneralTrait;

class CovenantController extends Controller
{
    use GeneralTrait;
    public function show_item(Request $request)
    {
        $request->validate([
            'driver_id'=>'required'
        ]);
        $data =   CovenantItem::select([
            'id',
            'covenant_name',
            'serial_number',
            'current_driver',
            'state',
            'delivery_date'
        ])->where('current_driver', $request->driver_id)->get();
        return $this -> returnData($data ,'data convanet');

        
    }
}
