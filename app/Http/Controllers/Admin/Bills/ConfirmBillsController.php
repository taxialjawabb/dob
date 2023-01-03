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
use App\Models\Vechile;
use App\Models\Admin;

class ConfirmBillsController extends Controller
{
    public function show_bills($type)
    {
        $bills = DB::select("
                        select 
                        t.id, t.name, t.bond_date, sum(t.take_bonds) as take_bonds , sum(take_money) as take_money, sum(t.spend_bonds) as spend_bonds , sum(t.spend_money) as spend_money
                        from 
                        (
                        select ad.id, ad.name,  date(add_date) as bond_date, 
                        count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                        sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                        count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                        sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                        from box_driver t1 
                        left join admins ad on  t1.add_by  = ad.id and t1.id  where t1.bond_state = 'waiting'   group by bond_date , ad.id
                        union all
                        select ad.id, ad.name,  date(add_date) as bond_date, 
                        count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                        sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                        count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                        sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                        from box_vechile t1 
                        left join admins ad on  t1.add_by  = ad.id and t1.id  where t1.bond_state = 'waiting'   group by bond_date , ad.id
                        union all
                        select ad.id, ad.name,  date(add_date) as bond_date, 
                        count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                        sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                        count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                        sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                        from box_rider t1 
                        left join admins ad on  t1.add_by  = ad.id and t1.id  where t1.bond_state = 'waiting'   group by bond_date , ad.id
                        union all
                        select  ad.id, ad.name,  date(add_date) as bond_date, 
                        count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                        sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                        count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                        sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                        from box_nathriaat t1 
                        left join admins ad on  t1.add_by  = ad.id and t1.id  where t1.bond_state = 'waiting'   group by bond_date , ad.id
                        union all
                        select ad.id, ad.name,  date(add_date) as bond_date, 
                        count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                        sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                        count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                        sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                        from box_user t1 
                        left join admins ad on  t1.add_by  = ad.id and t1.id  where t1.bond_state = 'waiting'   group by bond_date , ad.id
                        ) t group by bond_date , id order by bond_date;
                ");

                
                $take =0;
                $spend = 0;
                foreach($bills as $row){
                    $take += $row->take_money;
                    $spend += $row->spend_money;
                }
        return view('bills.billsWaitingConfirm', compact('bills', "take" , "spend"));
        
    }

    public function confirm_bills(Request $request)
    {
        $request->validate([            
            'date' =>  'required|date',
            'bonds' =>        'required|string',
        ]);
        $boxVechiles = BoxVechile::where('bond_state', 'waiting')->whereDate('add_date', $request->date)->where('add_by', $request->id)->get();
        $boxDrivers = BoxDriver::where('bond_state', 'waiting')->whereDate('add_date', $request->date)->where('add_by', $request->id)->get();
        $boxRiders = BoxRider::where('bond_state', 'waiting')->whereDate('add_date', $request->date)->where('add_by', $request->id)->get();
        $boxUsers = BoxUser::where('bond_state', 'waiting')->whereDate('add_date', $request->date)->where('add_by', $request->id)->get();
        $boxNathriaats = BoxNathriaat::where('bond_state', 'waiting')->whereDate('add_date', $request->date)->where('add_by', $request->id)->get();
        $counter =count($boxVechiles )+ count($boxDrivers )+ count($boxRiders )+ count($boxUsers )+ count($boxNathriaats );
        if($request->bonds == $counter){
            foreach ($boxVechiles as $boxVechile) {
                $boxVechile->bond_state = 'confirmed';
                $boxVechile->confirm_by =  Auth::guard('admin')->user()->id;
                $boxVechile->confirm_date = Carbon::now();
                $boxVechile->save();
            }
            foreach ($boxDrivers as $boxDriver) {
                $boxDriver->bond_state = 'confirmed';
                $boxDriver->confirm_by =  Auth::guard('admin')->user()->id;
                $boxDriver->confirm_date = Carbon::now();
                $boxDriver->save();
            }
            foreach ($boxRiders as $boxRider) {
                $boxRider->bond_state = 'confirmed';
                $boxRider->confirm_by =  Auth::guard('admin')->user()->id;
                $boxRider->confirm_date = Carbon::now();
                $boxRider->save();
            }
            foreach ($boxUsers as $boxUser) {
                $boxUser->bond_state = 'confirmed';
                $boxUser->confirm_by =  Auth::guard('admin')->user()->id;
                $boxUser->confirm_date = Carbon::now();
                $boxUser->save();
            }
            foreach ($boxNathriaats as $boxNathiraat) {
                $boxNathiraat->bond_state = 'confirmed';
                $boxNathiraat->confirm_by =  Auth::guard('admin')->user()->id;
                $boxNathiraat->confirm_date = Carbon::now();
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
            $boxAdded = ' and boxd.add_by = '. $request->id;
        }else{
            $boxAdded = ' and boxd.add_by is null';
        }
        $sql =  "  
                select 'مستخدم' as type,  boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
                boxd.descrpition,boxd.add_date, addedBy.name as addBy
                from box_user as boxd left join admins as addedBy on boxd.add_by = addedBy.id
                left join admins as bondOwner on boxd.user_id = bondOwner.id 
                where bond_state ='waiting' and date(boxd.add_date) = ? ".$boxAdded." union all
                select 'سائق' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
                boxd.descrpition,boxd.add_date, addedBy.name as addBy
                from box_driver as boxd left join admins as addedBy on boxd.add_by = addedBy.id
                left join driver as bondOwner on boxd.driver_id = bondOwner.id 
                where bond_state ='waiting' and date(boxd.add_date) = ? ".$boxAdded." union all
                select 'عميل' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
                boxd.descrpition,boxd.add_date, addedBy.name as addBy
                from box_rider as boxd left join admins as addedBy on boxd.add_by = addedBy.id
                left join rider as bondOwner on boxd.rider_id = bondOwner.id 
                where bond_state ='waiting' and date(boxd.add_date) = ? ".$boxAdded." union all
                select 'نثريات' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
                boxd.descrpition,boxd.add_date, addedBy.name as addBy
                from box_nathriaat as boxd left join admins as addedBy on boxd.add_by = addedBy.id
                left join stakeholders as bondOwner on boxd.stakeholders_id = bondOwner.id 
                where bond_state ='waiting' and date(boxd.add_date) = ? ".$boxAdded." union all
                select 'مركبة' as type, boxd.id, bondOwner.plate_number as name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
                boxd.descrpition,boxd.add_date, addedBy.name as addBy
                from box_vechile as boxd left join admins as addedBy on boxd.add_by = addedBy.id
                left join vechile as bondOwner on boxd.vechile_id = bondOwner.id 
                where bond_state ='waiting' and date(boxd.add_date) = ? ".$boxAdded." 
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
