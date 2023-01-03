<?php

namespace App\Http\Controllers\Admin\Bills;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GeneralBox;

class GeneralBoxController extends Controller
{
    public function show_general_box(Request $request)
    {
        $search = '';
        if($request->has('from_date') && $request->has('to_date')){
            $search = " where (deposited_date BETWEEN '".$request->from_date."' AND '".$request->to_date."') ";
        }
        $sql = "
                select 
                t.id,t.name , deposited_date, sum(t.take_bonds) as take_bonds , sum(take_money) as take_money, sum(t.spend_bonds) as spend_bonds , sum(t.spend_money) as spend_money
                from 
                (
                select ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, if( date(t1.trustworthy_date) is null , date(t1.add_date), date(deposit_date) )   as deposited_date, 
                count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                from box_driver t1 
                left join admins ad on  t1.deposited_by  = ad.id and t1.id  where  t1.bond_state = 'deposited'   group by deposited_date , ad.id
                union all
                select ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, if( date(t1.trustworthy_date) is null , date(t1.add_date), date(deposit_date) )   as deposited_date, 
                count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                from box_vechile t1 
                left join admins ad on  t1.deposited_by  = ad.id and t1.id  where t1.bond_state = 'deposited'   group by deposited_date , ad.id
                union all
                select ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, if( date(t1.trustworthy_date) is null , date(t1.add_date), date(deposit_date) )   as deposited_date,  
                count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                from box_rider t1 
                left join admins ad on  t1.deposited_by  = ad.id and t1.id  where t1.bond_state = 'deposited'   group by deposited_date , ad.id
                union all
                select  ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, if( date(t1.trustworthy_date) is null , date(t1.add_date), date(deposit_date) )   as deposited_date, 
                count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                from box_nathriaat t1 
                left join admins ad on  t1.deposited_by  = ad.id and t1.id  where t1.bond_state = 'deposited'   group by deposited_date , ad.id
                union all
                select ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, if( date(t1.trustworthy_date) is null , date(t1.add_date), date(deposit_date) )   as deposited_date, 
                count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds, 
                sum(CASE WHEN bond_type = 'take' THEN money ELSE 0 END) as take_money ,
                count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds, 
                sum(CASE WHEN bond_type = 'spend' THEN money ELSE 0 END) as spend_money 
                from box_user t1 
                left join admins ad on  t1.deposited_by  = ad.id and t1.id  where t1.bond_state = 'deposited'   group by deposited_date , ad.id
                ) t ". $search ."  group by deposited_date , id order by deposited_date;

            ";

        $bills =DB::select($sql);
        $generalBox = GeneralBox::find(1);

        
        return view('bills.generalBox', compact('bills', 'generalBox'));
    }

    public function show(Request $request)
    {

        $request->validate([            
            
            'bonds' =>        'required|string',
        ]);
  
        $boxAdded = '';
        $boxDate = '';
        $shownDate ='';
        if($request->id !== null){
            $boxAdded = ' and boxd.deposited_by = '. $request->id;
            $boxDate = "and date(boxd.deposit_date) =  '". $request->date."'";
            $shownDate =' boxd.deposit_date as deposit_date ';
        }else{
            $boxAdded = ' and boxd.deposited_by is null';
            $boxDate = "and date(boxd.add_date) = '". $request->date."'";
            $shownDate =' boxd.add_date as deposit_date ';
        }


        $sql =  "  
        
        select 'مستخدم' as type,  boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,". $shownDate.", depositedBy.name as depositedBy
        from box_user as boxd left join admins as depositedBy on boxd.deposited_by = depositedBy.id
        left join admins as bondOwner on boxd.user_id = bondOwner.id 
        where bond_state ='deposited' ".$boxDate."  ".$boxAdded." union all
        select 'سائق' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,". $shownDate.", depositedBy.name as depositedBy
        from box_driver as boxd left join admins as depositedBy on boxd.deposited_by = depositedBy.id
        left join driver as bondOwner on boxd.driver_id = bondOwner.id 
        where bond_state ='deposited' ".$boxDate."  ".$boxAdded." union all
        select 'عميل' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,". $shownDate.", depositedBy.name as depositedBy
        from box_rider as boxd left join admins as depositedBy on boxd.deposited_by = depositedBy.id
        left join rider as bondOwner on boxd.rider_id = bondOwner.id 
        where bond_state ='deposited' ".$boxDate."  ".$boxAdded." union all
        select 'نثريات' as type, boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,". $shownDate.", depositedBy.name as depositedBy
        from box_nathriaat as boxd left join admins as depositedBy on boxd.deposited_by = depositedBy.id
        left join stakeholders as bondOwner on boxd.stakeholders_id = bondOwner.id 
        where bond_state ='deposited' ".$boxDate."  ".$boxAdded." union all
        select 'مركبة' as type, boxd.id, bondOwner.plate_number as name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
        boxd.descrpition,". $shownDate.", depositedBy.name as depositedBy
        from box_vechile as boxd left join admins as depositedBy on boxd.deposited_by = depositedBy.id
        left join vechile as bondOwner on boxd.vechile_id = bondOwner.id 
        where bond_state ='deposited' ".$boxDate."  ".$boxAdded." 
            ";
        // return $sql;

        $bonds = DB::select($sql);
        return $bonds;
    }
}
