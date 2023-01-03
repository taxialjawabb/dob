<?php

namespace App\Traits;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait InternalTransfer
{
    
    public function transfer(Request $request)
    {
        if($request->stakeholder === 'driver'){
            $driver = \App\Models\Driver::find($request->user);
            if($driver !== null){
                $totalMoney =$request->money + (($request->money * $request->tax) / 100);
                $boxDriver = new \App\Models\Driver\BoxDriver;
                $boxDriver->driver_id = $request->user;
                $boxDriver->bond_type = $request->bond_type =='take'? 'spend' : 'take';
                $boxDriver->payment_type = $request->payment_type;
                $boxDriver->money = $request->money;
                $boxDriver->tax = $request->tax;
                $boxDriver->total_money = $totalMoney;
                $boxDriver->descrpition = $request->descrpition;
                $boxDriver->add_date = \Carbon\Carbon::now();
                $boxDriver->add_by = Auth::guard('admin')->user()->id;
                $boxDriver->save();
            }
        }
        else if($request->stakeholder === 'vechile'){
            $vechile =  \App\Models\Vechile::find($request->user);
            if($vechile !== null){
                $totalMoney = $request->money + (($request->money * $request->tax) / 100);
                $boxVechile = new \App\Models\Vechile\BoxVechile;
                $boxVechile->vechile_id = $request->user;
                $boxVechile->bond_type = $request->bond_type =='take'? 'spend' : 'take';
                $boxVechile->payment_type = $request->payment_type;
                $boxVechile->money = $request->money;
                $boxVechile->tax = $request->tax;
                $boxVechile->total_money = $totalMoney;
                $boxVechile->descrpition = $request->descrpition;
                $boxVechile->add_date = \Carbon\Carbon::now();
                $boxVechile->add_by = Auth::guard('admin')->user()->id;
                $boxVechile->save();
            }
        }
        else if($request->stakeholder === 'rider'){
            $rider = \App\Models\Rider::find($request->user);
            if($rider !== null){
                $totalMoney =$request->money + (($request->money * $request->tax) / 100);
                $BoxRider = new \App\Models\Rider\BoxRider;
                $BoxRider->rider_id = $request->user;
                $BoxRider->bond_type = $request->bond_type =='take'? 'spend' : 'take';
                $BoxRider->payment_type = $request->payment_type;
                $BoxRider->money = $request->money;
                $BoxRider->tax = $request->tax;
                $BoxRider->total_money = $totalMoney;
                $BoxRider->descrpition = $request->descrpition;
                $BoxRider->add_date = \Carbon\Carbon::now();
                $BoxRider->add_by = Auth::guard('admin')->user()->id;
                $BoxRider->save();
            }
        }
        else if($request->stakeholder === 'user'){
            $user = \App\Models\Admin::find($request->user);
            if($user !== null){
                $totalMoney =$request->money + (($request->money * $request->tax) / 100);
                $boxUser = new \App\Models\User\BoxUser;
                $boxUser->user_id = $request->user;
                $boxUser->bond_type = $request->bond_type =='take'? 'spend' : 'take';
                $boxUser->payment_type = $request->payment_type;
                $boxUser->money = $request->money;
                $boxUser->tax = $request->tax;
                $boxUser->total_money = $totalMoney;
                $boxUser->descrpition = $request->descrpition;
                $boxUser->add_date = \Carbon\Carbon::now();
                $boxUser->add_by = Auth::guard('admin')->user()->id;
                $boxUser->save();
            }
        }
        else if($request->stakeholder === 'stakeholder'){
            $stakeholder = \App\Models\Nathiraat\Stakeholders::find($request->user);
            if($stakeholder !== null){
                $totalMoney =$request->money + (($request->money * $request->tax) / 100);
                $boxNathriaat = new \App\Models\Nathiraat\BoxNathriaat;
                $boxNathriaat->stakeholders_id = $request->user;
                $boxNathriaat->bond_type =  $request->bond_type =='take'? 'spend' : 'take';
                $boxNathriaat->payment_type = $request->payment_type;
                $boxNathriaat->money = $request->money;
                $boxNathriaat->tax = $request->tax;
                $boxNathriaat->total_money = $totalMoney;
                $boxNathriaat->descrpition = $request->descrpition;
                $boxNathriaat->add_date = \Carbon\Carbon::now();
                $boxNathriaat->add_by = Auth::guard('admin')->user()->id;
                $boxNathriaat->save();
            }
        }
    }

}