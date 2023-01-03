<?php

namespace App\Http\Controllers\Admin\Groups\GroupDriver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Groups\Group;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Nathiraat\BoxNathriaat;

class GroupDriverBalanceController extends Controller
{
    public function show_box($type , $id)
    {
        $group = Group::find($id);
        if($group === null){
            return back();
        }
        if($type === 'spend'){
            $bonds = DB::select("
            select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
            boxd.descrpition,boxd.add_date,admins.name as admin_name
            from box_nathriaat as boxd left join   stakeholders  on boxd.stakeholders_id = stakeholders.id
            left join  admins on  boxd.add_by = admins.id  where
            stakeholders.id = 8  and boxd.bond_type = 'spend' and boxd.foreign_type = 'group' and boxd.foreign_id = ?
            ", [$id]);
            return view('groups.manageGroups.boxGroup.showBoxGroup', compact('bonds','type', 'group'));
        }
        else if($type === 'take'){
            $bonds = DB::select("
            select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
            boxd.descrpition,boxd.add_date,admins.name as admin_name
            from box_nathriaat as boxd left join   stakeholders  on boxd.stakeholders_id = stakeholders.id
            left join  admins on  boxd.add_by = admins.id  where
            stakeholders.id = 8  and boxd.bond_type = 'take' and boxd.foreign_type = 'group' and boxd.foreign_id = ?
            ", [$id]);
            return view('groups.manageGroups.boxGroup.showBoxGroup', compact( 'bonds','type', 'group'));
        }
        else{
            return back();
        }
    }

    public function show_bond($id)
    {
        $group = Group::find($id);
        if($group !== null){
            return view('groups.manageGroups.boxGroup.addBoxGroup', compact('group'));
        }
        else{
            return back();

        }
    }

    public function add_box(Request $request)
    {
        $request->validate([
            'group_id' =>     'required|integer',
            'bond_type' =>  'required|string|in:take,spend',
            'payment_type' =>        'required|string|in:cash,bank transfer,internal transfer,selling points,electronic payment',
            'money' =>          'required|numeric',
            'tax' =>        'required|numeric',
            'descrpition' =>        'required|string',
        ]);
        $group = Group::find($request->group_id);
        if($group === null){
            return back();
        }
            $totalMoney =$request->money + (($request->money * $request->tax) / 100);
            $boxNathriaat = new BoxNathriaat;
            $boxNathriaat->stakeholders_id = 8 ;
            $boxNathriaat->foreign_type = 'group';
            $boxNathriaat->foreign_id = $group->id;
            $boxNathriaat->bond_type = $request->bond_type;
            $boxNathriaat->payment_type = $request->payment_type;
            $boxNathriaat->money = $request->money;
            $boxNathriaat->tax = $request->tax;
            $boxNathriaat->total_money = $totalMoney;
            $boxNathriaat->descrpition = $request->descrpition;
            $boxNathriaat->add_date = Carbon::now();
            $boxNathriaat->add_by = Auth::guard('admin')->user()->id;
            if($request->bond_type === 'take'){
                $group-> account = $group-> account + $totalMoney;
            }else if($request->bond_type === 'spend'){
                $group-> account = $group-> account - $totalMoney;
            }
            $group->save();
            $boxNathriaat->save();
            // $stakeholder->save();

            $request->session()->flash('status', 'تم أضافة السند بنجاح');
            return redirect()->route('manage.groups.box.show', ['type' => $request->bond_type, 'id' => $request->group_id]);
    }
}
