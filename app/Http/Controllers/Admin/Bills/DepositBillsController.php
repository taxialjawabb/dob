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

class DepositBillsController extends Controller
{
    public function show_bills($type)
    {

        $bills = DB::select("select 
        t.id, t.name, t.trustworthed_date, sum(t.take_bonds) as take_bonds , sum(take_money) as take_money, sum(t.spend_bonds) as spend_bonds , sum(t.spend_money) as spend_money
        from 
        (
        select ad.id, ad.name,  date(trustworthy_date) as trustworthed_date, 
        count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
        sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
        count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
        sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
        from box_driver t1 
        left join admins ad on  t1.trustworthy_by  = ad.id and t1.id  where t1.bond_state = 'trustworthy'   group by trustworthed_date , ad.id
        union all
        select ad.id, ad.name,  date(trustworthy_date) as trustworthed_date, 
        count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
        sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
        count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
        sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
        from box_vechile t1 
        left join admins ad on  t1.trustworthy_by  = ad.id and t1.id  where t1.bond_state = 'trustworthy'   group by trustworthed_date , ad.id
        union all
        select ad.id, ad.name,  date(trustworthy_date) as trustworthed_date, 
        count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
        sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
        count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
        sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
        from box_rider t1 
        left join admins ad on  t1.trustworthy_by  = ad.id and t1.id  where t1.bond_state = 'trustworthy'   group by trustworthed_date , ad.id
        union all
        select  ad.id, ad.name,  date(trustworthy_date) as trustworthed_date, 
        count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
        sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
        count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
        sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
        from box_nathriaat t1 
        left join admins ad on  t1.trustworthy_by  = ad.id and t1.id  where t1.bond_state = 'trustworthy'   group by trustworthed_date , ad.id
        union all
        select ad.id, ad.name,  date(trustworthy_date) as trustworthed_date, 
        count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
        sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
        count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
        sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
        from box_user t1 
        left join admins ad on  t1.trustworthy_by  = ad.id and t1.id  where t1.bond_state = 'trustworthy'   group by trustworthed_date , ad.id
        ) t group by trustworthed_date , id order by trustworthed_date;");
        $take =0;
        $spend = 0;
        foreach($bills as $row){
            $take += $row->take_money;
            $spend += $row->spend_money;
        }
        return view('bills.billsWaitingDeposit', compact('bills', 'take', "spend"));
    }

    public function deposit_bills(Request $request)
    {
        $request->validate([            
            'date' =>  'required|date',
            'bonds' =>        'required|string',
        ]);
        $boxVechiles = BoxVechile::where('bond_state', 'trustworthy')->whereDate('trustworthy_date', $request->date)->where('trustworthy_by', $request->id)->get();
        $boxDrivers = BoxDriver::where('bond_state', 'trustworthy')->whereDate('trustworthy_date', $request->date)->where('trustworthy_by', $request->id)->get();
        $boxRiders = BoxRider::where('bond_state', 'trustworthy')->whereDate('trustworthy_date', $request->date)->where('trustworthy_by', $request->id)->get();
        $boxUsers = BoxUser::where('bond_state', 'trustworthy')->whereDate('trustworthy_date', $request->date)->where('trustworthy_by', $request->id)->get();
        $boxNathriaats = BoxNathriaat::where('bond_state', 'trustworthy')->whereDate('trustworthy_date', $request->date)->where('trustworthy_by', $request->id)->get();
        $counter =count($boxVechiles )+ count($boxDrivers )+ count($boxRiders )+ count($boxUsers )+ count($boxNathriaats );

        if($request->bonds == $counter){
            foreach ($boxVechiles as $boxVechile) {
                $boxVechile->bond_state = 'deposited';
                $boxVechile->deposited_by =  Auth::guard('admin')->user()->id;
                $boxVechile->deposit_date = Carbon::now();
                $boxVechile->bank_account_number = $request->bank_account_number;
                if($boxVechile->bond_type == "spend"){
                    $this->generalBox(0, $boxVechile->total_money , Carbon::now());
                }
                else if($boxVechile->bond_type == "take"){
                    $this->generalBox( $boxVechile->total_money,0 , Carbon::now());
                }
                $boxVechile->save();
            }
            foreach ($boxDrivers as $boxDriver) {
                $boxDriver->bond_state = 'deposited';
                $boxDriver->deposited_by =  Auth::guard('admin')->user()->id;
                $boxDriver->deposit_date = Carbon::now();
                $boxDriver->bank_account_number = $request->bank_account_number;
                if($boxDriver->bond_type == "spend"){
                    $this->generalBox(0, $boxDriver->total_money , Carbon::now());
                }
                else if($boxDriver->bond_type == "take"){
                    $this->generalBox( $boxDriver->total_money,0 , Carbon::now());
                }
                $boxDriver->save();
            }
            foreach ($boxRiders as $boxRider) {
                $boxRider->bond_state = 'deposited';
                    $boxRider->deposited_by =  Auth::guard('admin')->user()->id;
                    $boxRider->deposit_date = Carbon::now();
                    $boxRider->bank_account_number = $request->bank_account_number;
                    if($boxRider->bond_type == "spend"){
                        $this->generalBox(0, $boxRider->total_money , Carbon::now());
                    }
                    else if($boxRider->bond_type == "take"){
                        $this->generalBox( $boxRider->total_money,0 , Carbon::now());
                    }
                    $boxRider->save();
            }
            foreach ($boxUsers as $boxUser) {
                $boxUser->bond_state = 'deposited';
                $boxUser->deposited_by =  Auth::guard('admin')->user()->id;
                $boxUser->deposit_date = Carbon::now();
                $boxUser->bank_account_number = $request->bank_account_number;
                if($boxUser->bond_type == "spend"){
                    $this->generalBox(0, $boxUser->total_money , Carbon::now());
                }
                else if($boxUser->bond_type == "take"){
                    $this->generalBox( $boxUser->total_money,0 , Carbon::now());
                }
                $boxUser->save();
            }
            foreach ($boxNathriaats as $boxNathiraat) {
                $boxNathiraat->bond_state = 'deposited';
                $boxNathiraat->deposited_by =  Auth::guard('admin')->user()->id;
                $boxNathiraat->deposit_date = Carbon::now();
                $boxNathiraat->bank_account_number = $request->bank_account_number;
                if($boxNathiraat->bond_type == "spend"){
                    $this->generalBox(0, $boxNathiraat->total_money , Carbon::now());
                }
                else if($boxNathiraat->bond_type == "take"){
                    $this->generalBox( $boxNathiraat->total_money,0 , Carbon::now());
                }
                $boxNathiraat->save();
            }
           return back();

        }else{
            return back();
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
            $boxAdded = ' and boxd.trustworthy_by = '. $request->id;
        }else{
            $boxAdded = ' and boxd.trustworthy_by is null';
        }
        $sql =  " 
        select 'مستخدم' as type,  boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,boxd.trustworthy_date, trustworthyBy.name as trustworthyBy
        from box_user as boxd left join admins as trustworthyBy on boxd.trustworthy_by = trustworthyBy.id
        left join admins as bondOwner on boxd.user_id = bondOwner.id 
        where bond_state ='trustworthy' and date(boxd.trustworthy_date) = ? ".$boxAdded." union all
        select 'سائق' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,boxd.trustworthy_date, trustworthyBy.name as trustworthyBy
        from box_driver as boxd left join admins as trustworthyBy on boxd.trustworthy_by = trustworthyBy.id
        left join driver as bondOwner on boxd.driver_id = bondOwner.id 
        where bond_state ='trustworthy' and date(boxd.trustworthy_date) = ? ".$boxAdded." union all
        select 'عميل' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,boxd.trustworthy_date, trustworthyBy.name as trustworthyBy
        from box_rider as boxd left join admins as trustworthyBy on boxd.trustworthy_by = trustworthyBy.id
        left join rider as bondOwner on boxd.rider_id = bondOwner.id 
        where bond_state ='trustworthy' and date(boxd.trustworthy_date) = ? ".$boxAdded." union all
        select 'نثريات' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,boxd.trustworthy_date, trustworthyBy.name as trustworthyBy
        from box_nathriaat as boxd left join admins as trustworthyBy on boxd.trustworthy_by = trustworthyBy.id
        left join stakeholders as bondOwner on boxd.stakeholders_id = bondOwner.id 
        where bond_state ='trustworthy' and date(boxd.trustworthy_date) = ? ".$boxAdded." union all
        select 'مركبة' as type, boxd.id, bondOwner.plate_number as name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,boxd.trustworthy_date, trustworthyBy.name as trustworthyBy
        from box_vechile as boxd left join admins as trustworthyBy on boxd.trustworthy_by = trustworthyBy.id
        left join vechile as bondOwner on boxd.vechile_id = bondOwner.id 
        where bond_state ='trustworthy' and date(boxd.trustworthy_date) = ? ".$boxAdded." 
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
