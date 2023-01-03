<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;

class BoxRiderQueryController extends Controller
{
    use GeneralTrait;
    public function get_bonds(Request $request)
    {
    $request->validate([
            'rider_id' =>'required',
            ]);


            $first = DB::table('box_vechile')
            ->select([
                'box_vechile.id',
                'box_vechile.bond_type',
                'box_vechile.payment_type',
                'box_vechile.money',
                'box_vechile.tax',
                'box_vechile.total_money',
                'box_vechile.descrpition',
                'box_vechile.add_date',
            ])
            ->where('box_vechile.foreign_type','rider')
            ->where('box_vechile.foreign_id',$request->rider_id);

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
            ->union($first)->orderBy('add_date', 'desc')
            ->paginate(10);
        if(count($data)>0){
            return  $this -> returnData('bonds' , $data, 'list of bonds') ;
        }
        else{
            return $this->returnError('E001', "Rider do not have bonds");
        }
    }
}
