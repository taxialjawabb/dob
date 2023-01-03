<?php

namespace App\Http\Controllers\Admin\Bills;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Vechile\BoxVechile;
use App\Models\Driver\BoxDriver;
use App\Models\Rider\BoxRider;
use App\Models\User\BoxUser;
use App\Models\Nathiraat\BoxNathriaat;
use App\Models\Driver;

class TrutworthyBillsController extends Controller
{
    public function show_bills($type)
    {
        $bills = DB::select("
                            select 
                            t.id, t.name, t.confirmed_date, sum(t.take_bonds) as take_bonds , sum(take_money) as take_money, sum(t.spend_bonds) as spend_bonds , sum(t.spend_money) as spend_money
                            from 
                            (
                            select ad.id, ad.name,  date(confirm_date) as confirmed_date, 
                            count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                            sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                            count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                            sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                            from box_driver t1 
                            left join admins ad on  t1.confirm_by  = ad.id and t1.id  where t1.bond_state = 'confirmed'   group by confirmed_date , ad.id
                            union all
                            select ad.id, ad.name,  date(confirm_date) as confirmed_date, 
                            count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                            sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                            count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                            sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                            from box_vechile t1 
                            left join admins ad on  t1.confirm_by  = ad.id and t1.id  where t1.bond_state = 'confirmed'   group by confirmed_date , ad.id
                            union all
                            select ad.id, ad.name,  date(confirm_date) as confirmed_date, 
                            count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                            sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                            count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                            sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                            from box_rider t1 
                            left join admins ad on  t1.confirm_by  = ad.id and t1.id  where t1.bond_state = 'confirmed'   group by confirmed_date , ad.id
                            union all
                            select  ad.id, ad.name,  date(confirm_date) as confirmed_date, 
                            count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                            sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                            count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                            sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                            from box_nathriaat t1 
                            left join admins ad on  t1.confirm_by  = ad.id and t1.id  where t1.bond_state = 'confirmed'   group by confirmed_date , ad.id
                            union all
                            select ad.id, ad.name,  date(confirm_date) as confirmed_date, 
                            count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                            sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                            count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                            sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                            from box_user t1 
                            left join admins ad on  t1.confirm_by  = ad.id and t1.id  where t1.bond_state = 'confirmed'   group by confirmed_date , ad.id
                            ) t group by confirmed_date , id order by confirmed_date;
                ");


                $take =0;
                $spend = 0;
                foreach($bills as $row){
                    $take += $row->take_money;
                    $spend += $row->spend_money;
                }
        
        return view('bills.billsWaitingTrustworthy', compact('bills', "take" , "spend"));
    }

    public function trustworthy_bills(Request $request)
    {
        $request->validate([            
            'date' =>  'required|date',
            'bonds' =>        'required|string',
        ]);
        $boxVechiles = BoxVechile::where('bond_state', 'confirmed')->whereDate('confirm_date', $request->date)->where('confirm_by', $request->id)->get();
        $boxDrivers = BoxDriver::where('bond_state', 'confirmed')->whereDate('confirm_date', $request->date)->where('confirm_by', $request->id)->get();
        $boxRiders = BoxRider::where('bond_state', 'confirmed')->whereDate('confirm_date', $request->date)->where('confirm_by', $request->id)->get();
        $boxUsers = BoxUser::where('bond_state', 'confirmed')->whereDate('confirm_date', $request->date)->where('confirm_by', $request->id)->get();
        $boxNathriaats = BoxNathriaat::where('bond_state', 'confirmed')->whereDate('confirm_date', $request->date)->where('confirm_by', $request->id)->get();
        $counter =count($boxVechiles )+ count($boxDrivers )+ count($boxRiders )+ count($boxUsers )+ count($boxNathriaats );
        // return $boxNathriaats;
        if($request->bonds == $counter){
            foreach ($boxVechiles as $boxVechile) {
                $boxVechile->bond_state = 'trustworthy';
                    $boxVechile->trustworthy_by =  Auth::guard('admin')->user()->id;
                    $boxVechile->trustworthy_date = Carbon::now();
                    $vechile = \App\Models\Vechile::find($boxVechile->vechile_id);
                    if($boxVechile->bond_type === 'take'){
                        $vechile-> account = $vechile-> account + $boxVechile->total_money;
                    }else if($boxVechile->bond_type === 'spend'){
                        $vechile-> account = $vechile-> account - $boxVechile->total_money;
                    }
                    $vechile->save();
                    if($boxVechile->payment_type == 'bank transfer'  || $boxVechile->payment_type == 'selling points' || $boxVechile->payment_type == 'electronic payment' || $boxVechile->payment_type == 'internal transfer'){
                        $boxVechile->bond_state = 'deposited';
                        $boxVechile->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxVechile->deposit_date = Carbon::now();
                        if($boxVechile->payment_type !== 'internal transfer'){
                            if($boxVechile->bond_type == "spend"){
                                $this->generalBox(0, $boxVechile->total_money , Carbon::now());
                            }
                            else if($boxVechile->bond_type == "take"){
                                $this->generalBox( $boxVechile->total_money,0 , Carbon::now());
                            }
                        }                        
                    }
                    if($boxVechile->payment_type == 'cash' && $boxVechile->bond_type == "spend"){
                        $boxVechile->bond_state = 'deposited';
                        $boxVechile->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxVechile->deposit_date = Carbon::now();
                        $this->generalBox(0, $boxVechile->total_money , Carbon::now());
                    }
                    $boxVechile->save();
            }
            foreach ($boxDrivers as $boxDriver) {
                $boxDriver->bond_state = 'trustworthy';
                $boxDriver->trustworthy_by =  Auth::guard('admin')->user()->id;
                $boxDriver->trustworthy_date = Carbon::now();
                $driver = Driver::find($boxDriver->driver_id);
                if($boxDriver->bond_type == "spend"){
                    $driver-> account = $driver-> account - $boxDriver->total_money;
                }
                else if($boxDriver->bond_type == "take"){
                    $driver-> account = $driver-> account + $boxDriver->total_money;
                }
                $driver->save();
                if($boxDriver->payment_type == 'bank transfer'  || $boxDriver->payment_type == 'selling points' || $boxDriver->payment_type == 'electronic payment' || $boxDriver->payment_type == 'internal transfer'){
                    $boxDriver->bond_state = 'deposited';
                    $boxDriver->deposited_by =  Auth::guard('admin')->user()->id;
                    $boxDriver->deposit_date = Carbon::now();
                    if($boxDriver->payment_type !== 'internal transfer'){
                        if($boxDriver->bond_type == "spend"){
                            $this->generalBox(0, $boxDriver->total_money , Carbon::now());
                        }
                        else if($boxDriver->bond_type == "take"){
                            $this->generalBox( $boxDriver->total_money,0 , Carbon::now());
                        }
                    }
                    $driver->save();

                }
                if($boxDriver->payment_type == 'cash' && $boxDriver->bond_type == "spend"){
                    $boxDriver->bond_state = 'deposited';
                    $boxDriver->deposited_by =  Auth::guard('admin')->user()->id;
                    $boxDriver->deposit_date = Carbon::now();
                    $this->generalBox(0, $boxDriver->total_money , Carbon::now());
                }
                $boxDriver->save();
            }
            foreach ($boxRiders as $boxRider) {
                $boxRider->bond_state = 'trustworthy';
                $boxRider->trustworthy_by =  Auth::guard('admin')->user()->id;
                $boxRider->trustworthy_date = Carbon::now();
                $rider = \App\Models\Rider::find($boxRider->rider_id);
                if($boxRider->bond_type === 'take'){
                    $rider-> account = $rider-> account + $boxRider->total_money;
                }else if($boxRider->bond_type === 'spend'){
                    $rider-> account = $rider-> account - $boxRider->total_money;
                }
                $rider->save();
                if($boxRider->payment_type == 'bank transfer'  || $boxRider->payment_type == 'selling points' || $boxRider->payment_type == 'electronic payment' || $boxRider->payment_type == 'internal transfer'){
                    $boxRider->bond_state = 'deposited';
                    $boxRider->deposited_by =  Auth::guard('admin')->user()->id;
                    $boxRider->deposit_date = Carbon::now();
                    if($boxRider->payment_type !== 'internal transfer'){
                        if($boxRider->bond_type == "spend"){
                            $this->generalBox(0, $boxRider->total_money , Carbon::now());
                        }
                        else if($boxRider->bond_type == "take"){
                            $this->generalBox( $boxRider->total_money,0 , Carbon::now());
                        }
                    }        
                }
                if($boxRider->payment_type == 'cash' && $boxRider->bond_type == "spend"){
                    $boxRider->bond_state = 'deposited';
                    $boxRider->deposited_by =  Auth::guard('admin')->user()->id;
                    $boxRider->deposit_date = Carbon::now();
                    $this->generalBox(0, $boxRider->total_money , Carbon::now());
                }
                $boxRider->save();
            }
            foreach ($boxUsers as $boxUser) {
                $boxUser->bond_state = 'trustworthy';
                $boxUser->trustworthy_by =  Auth::guard('admin')->user()->id;
                $boxUser->trustworthy_date = Carbon::now();
                $user = \App\Models\Admin::find($boxUser->user_id);
                if($boxUser->bond_type === 'take'){
                    $user-> account = $user-> account + $boxUser->total_money;
                }else if($boxUser->bond_type === 'spend'){
                    $user-> account = $user-> account - $boxUser->total_money;
                }
                $user->save();
                if($boxUser->payment_type == 'bank transfer'  || $boxUser->payment_type == 'selling points' || $boxUser->payment_type == 'electronic payment' || $boxUser->payment_type == 'internal transfer'){
                    $boxUser->bond_state = 'deposited';
                    $boxUser->deposited_by =  Auth::guard('admin')->user()->id;
                    $boxUser->deposit_date = Carbon::now();
                    if($boxUser->payment_type !== 'internal transfer'){
                        if($boxUser->bond_type == "spend"){
                            $this->generalBox(0, $boxUser->total_money , Carbon::now());
                        }
                        else if($boxUser->bond_type == "take"){
                            $this->generalBox( $boxUser->total_money,0 , Carbon::now());
                        }
                    }
                }
                if($boxUser->payment_type == 'cash' && $boxUser->bond_type == "spend"){
                    $boxUser->bond_state = 'deposited';
                    $boxUser->deposited_by =  Auth::guard('admin')->user()->id;
                    $boxUser->deposit_date = Carbon::now();
                    $this->generalBox(0, $boxUser->total_money , Carbon::now());
                }
                $boxUser->save();
            }
            foreach ($boxNathriaats as $boxNathiraat) {
                    $boxNathiraat->bond_state = 'trustworthy';
                    $boxNathiraat->trustworthy_by =  Auth::guard('admin')->user()->id;
                    $boxNathiraat->trustworthy_date = Carbon::now();
                    $stakeholder = \App\Models\Nathiraat\Stakeholders::find($boxNathiraat->stakeholders_id);
                    if($boxNathiraat->bond_type === 'take'){
                        $stakeholder-> account = $stakeholder-> account + $boxNathiraat->total_money;
                    }else if($boxNathiraat->bond_type === 'spend'){
                        $stakeholder-> account = $stakeholder-> account - $boxNathiraat->total_money;
                    }
                    $stakeholder->save();
                    if($boxNathiraat->payment_type == 'bank transfer'  || $boxNathiraat->payment_type == 'selling points' || $boxNathiraat->payment_type == 'electronic payment' || $boxNathiraat->payment_type == 'internal transfer'){
                        $boxNathiraat->bond_state = 'deposited';
                        $boxNathiraat->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxNathiraat->deposit_date = Carbon::now();
                        if($boxNathiraat->payment_type !== 'internal transfer'){
                            if($boxNathiraat->bond_type == "spend"){
                                $this->generalBox(0, $boxNathiraat->total_money , Carbon::now());
                            }
                            else if($boxNathiraat->bond_type == "take"){
                                $this->generalBox( $boxNathiraat->total_money,0 , Carbon::now());
                            }
                        }
                    }
                    if($boxNathiraat->payment_type == 'cash' && $boxNathiraat->bond_type == "spend"){
                        $boxNathiraat->bond_state = 'deposited';
                        $boxNathiraat->deposited_by =  Auth::guard('admin')->user()->id;
                        $boxNathiraat->deposit_date = Carbon::now();
                        $this->generalBox(0, $boxNathiraat->total_money , Carbon::now());
                    }
                    $boxNathiraat->save();
            }
            return 1;
        }else{
            return 2;
        }
    }

    public function show(Request $request)
    {
        $request->validate([            
            'date' =>  'required|date',
            'bonds' =>        'required|string',
        ]);
  
        $boxAdded = '';
        if($request->id !== null){
            $boxAdded = ' and boxd.confirm_by = '. $request->id;
        }else{
            $boxAdded = ' and boxd.confirm_by is null';
        }
        $sql =  "  
        select 'مستخدم' as type,  boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,boxd.confirm_date, confirmedBy.name as confirmedBy
        from box_user as boxd left join admins as confirmedBy on boxd.confirm_by = confirmedBy.id
        left join admins as bondOwner on boxd.user_id = bondOwner.id 
        where bond_state ='confirmed' and date(boxd.confirm_date) = ? ".$boxAdded." union all
        select 'سائق' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,boxd.confirm_date, confirmedBy.name as confirmedBy
        from box_driver as boxd left join admins as confirmedBy on boxd.confirm_by = confirmedBy.id
        left join driver as bondOwner on boxd.driver_id = bondOwner.id 
        where bond_state ='confirmed' and date(boxd.confirm_date) = ? ".$boxAdded." union all
        select 'عميل' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,boxd.confirm_date, confirmedBy.name as confirmedBy
        from box_rider as boxd left join admins as confirmedBy on boxd.confirm_by = confirmedBy.id
        left join rider as bondOwner on boxd.rider_id = bondOwner.id 
        where bond_state ='confirmed' and date(boxd.confirm_date) = ? ".$boxAdded." union all
        select 'نثريات' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,boxd.confirm_date, confirmedBy.name as confirmedBy
        from box_nathriaat as boxd left join admins as confirmedBy on boxd.confirm_by = confirmedBy.id
        left join stakeholders as bondOwner on boxd.stakeholders_id = bondOwner.id 
        where bond_state ='confirmed' and date(boxd.confirm_date) = ? ".$boxAdded." union all
        select 'مركبة' as type, boxd.id, bondOwner.plate_number as name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,boxd.confirm_date, confirmedBy.name as confirmedBy
        from box_vechile as boxd left join admins as confirmedBy on boxd.confirm_by = confirmedBy.id
        left join vechile as bondOwner on boxd.vechile_id = bondOwner.id 
        where bond_state ='confirmed' and date(boxd.confirm_date) = ? ".$boxAdded." 
            ";
        $bonds = DB::select($sql, [
            $request->date,
            $request->date,
            $request->date,
            $request->date,
            $request->date,
        ]);
        return $bonds;
    }
}

