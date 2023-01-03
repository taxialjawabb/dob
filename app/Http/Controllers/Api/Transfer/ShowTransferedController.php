<?php

namespace App\Http\Controllers\Api\Transfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class ShowTransferedController extends Controller
{
    use GeneralTrait;
    public function get_transfered_bonds(Request $request)
    {
            $request->validate([
                'rider_id' =>'required',
            ]);

        $data = DB::table('box_rider')
        ->select([
            'box_rider.id',
            'box_rider.bond_type',
            'box_rider.payment_type',
            'box_rider.money',
            'box_rider.tax',
            'box_rider.total_money',
            'box_rider.descrpition',
            'box_rider.add_date',
        ])
        ->where('box_rider.rider_id', $request->rider_id)
        ->where('box_rider.confirm_by', -1)
        ->where('box_rider.trustworthy_by', -1)
        ->orderBy('add_date', 'desc')
            ->paginate(10);
        if(count($data)>0){
            return  $this -> returnData('bonds' , $data, 'list of bonds') ;
        }
        else{
            return $this->returnError('E001', "Rider do not have bonds");
        }
    }

    public function get_transfered_bonds_driver(Request $request)
    {
        $request->validate([
            'driver_id' =>'required',
        ]);
        
        $data = DB::table('box_driver')
        ->select(
            'box_driver.id',
            'box_driver.payment_type',
            'box_driver.money',
            'box_driver.tax',
            'box_driver.total_money',
            'box_driver.descrpition',
            'box_driver.add_date',
            'box_driver.bond_type'
            // DB::raw( "IF(box_driver.bond_type = 'spend', 'take', 'spend') as bond_type")
            )
        ->where('box_driver.driver_id', $request->driver_id)
        ->where('box_driver.confirm_by', -1)
        ->where('box_driver.trustworthy_by', -1)
        ->orderBy('add_date', 'desc')
        ->paginate(10);

        if(count($data)>0){
            return  $this -> returnData('bonds' , $data, 'list of bonds') ;
        }
        else{
            return $this->returnError('E001', "Driver do not have bonds");
        }
    }

}
