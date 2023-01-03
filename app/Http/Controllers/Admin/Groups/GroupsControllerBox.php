<?php

namespace App\Http\Controllers\Admin\Groups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Models\Driver;
use App\Models\Groups\Group;
use App\Models\Groups\GroupUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GroupsControllerBox extends Controller
{
    public function show_box($type, $id)
    {
        $driver = Driver::find($id);
        if ($driver !== null) {
            if ($type === 'spend') {
                $bonds = DB::select("
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date, admins.name as admin_name
                from group_driver_balance as boxd left join admins  on boxd.add_by=admins.id where  driver_id = ? and boxd.bond_type = 'spend'
                 ", [$id]);
                return view('groups.driver.box.showBoxDriver', compact('driver', 'bonds', 'type'));
            } else if ($type === 'take') {
                $bonds = DB::select("select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date,admins.name as admin_name
                from group_driver_balance as boxd , driver ,admins  where  boxd.add_by = admins.id and boxd.driver_id = driver.id and driver.id = ? and boxd.bond_type = 'take' 
                ;", [$id]);
                return view('groups.driver.box.showBoxDriver', compact('driver', 'bonds', 'type'));
            } else {
                return back();
            }
        } else {
            return back();
        }
    }
    public function show_add($id)
    {
        $driver = Driver::find($id);
        if ($driver !== null) 
        {
            $group = Group::where('id', $driver->group_id)->where('state', 'active')->get();
          
            if (count($group) > 0)
             {
                $groupUser = GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $group[0]->id)->where('state', 'active')->get();
                
                if (count($groupUser) > 0) {
                    return  view('groups.driver.box.addBoxDriver', compact('driver'));
                }
            }
        }
        session()->flash('status', 'لايمكن اضافه سند لهذا السائق');
        return back();
    }
    public function save_add(Request $request)
    {
        $request->validate([
            'driver_id' =>     'required|integer',
            'bond_type' =>  'required|string|in:take,spend',
            'payment_type' =>        'required|string|in:cash,bank transfer,internal transfer,selling points,electronic payment',
            'money' =>          'required|numeric',
            'tax' =>        'required|numeric',
            'descrpition' =>        'required|string',
        ]);
        if ($request->has('stakeholder')) {
            $request->validate([
                'stakeholder' => 'required|string|in:driver,vechile,rider,stakeholder,user',
                'user' => 'required|integer'
            ]);
            $this->transfer($request);
        }
        $driver = Driver::find($request->driver_id);
        if ($driver !== null) {
            $totalMoney = $request->money + (($request->money * $request->tax) / 100);
            if ($request->bond_type == 'spend') {
                $driver->group_balance -= $totalMoney;
            } else {
                $driver->group_balance += $totalMoney;
            }

            $boxDriver = new \App\Models\Groups\GroupsBalance;
            $boxDriver->group_id = $driver->group_id;
            $boxDriver->driver_id = $request->driver_id;
            $boxDriver->bond_type = $request->bond_type;
            $boxDriver->payment_type = $request->payment_type;
            $boxDriver->money = $request->money;
            $boxDriver->tax = $request->tax;
            $boxDriver->total_money = $totalMoney;

            $boxDriver->descrpition = $request->descrpition;
            $boxDriver->add_date = Carbon::now();
            $boxDriver->add_by = Auth::guard('admin')->user()->id;
            $driver->save();
            $boxDriver->save();

            $request->session()->flash('status', 'تم أضافة السند بنجاح');
            return redirect("groups/driver/box/show/" . $request->bond_type . "/" . $driver->id);
        } else {
            return redirect('driver/show');
        }
    }
}
