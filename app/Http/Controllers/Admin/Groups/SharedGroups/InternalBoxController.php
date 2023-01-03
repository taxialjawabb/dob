<?php

namespace App\Http\Controllers\Admin\Groups\SharedGroups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Groups\Group;
use App\Models\Groups\GroupUser;
use App\Models\Vechile;
use App\Models\Driver;
use App\Models\Vechile\VechileNotes;
use Auth;
use Carbon\Carbon;
use DB;
class InternalBoxController extends Controller
{
    public function show_box_driver(Driver $driver , Group $group,$type){
        // $data = driver->group_bill;
        // return $data;
        $bonds= $this->show_box('driver', $driver->id,  $group, $type);
        if($bonds === false){
            return back();
        }else{
            return view('groups.shared.driver.box.showBoxDriver', compact('driver', 'bonds', 'type', 'group'));
        }
    }
    public function show_box_vechile(Vechile $vechile , Group $group,$type){
        $bonds= $this->show_box('vechile', $vechile->id,  $group, $type);
        if($bonds === false){
            return back();
        }else{
            return view('groups.shared.vechile.box.showBoxVechile', compact('vechile', 'bonds', 'type', 'group'));
        }
    }
    public function show_box_user(Admin $user , Group $group,$type){

        $bonds= $this->show_box('user', $user->id,  $group, $type);

        if($bonds === false){
            return back();
        }else{
            $groupUser = GroupUser::where('user_id', $user->id)->where('group_id' , $group->id)->first();
            return view('groups.shared.user.box.showBoxUser', compact('user', 'bonds', 'type', 'group', 'groupUser'));
        }
    }
    public function show_box($directed_to , $id, Group $group,$type)
        {
            if ($this->hasPermissionData($group->id) == false){
                session()->flash('error', 'ليس لديك صلاحية للوصول لبيانات الجروب');
                return false;
            }
                 $bonds = [];

                if ($type === 'spend') {
                    $bonds = DB::select("
                    select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date, admins.name as admin_name
                    from group_internal_box as boxd left join admins  on boxd.add_by=admins.id where  foreign_type =? and foreign_id = ? and boxd.bond_type = 'spend'
                     ", [$directed_to , $id,]);
                    return $bonds;
                } else if ($type === 'take') {
                    $bonds = DB::select("select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date,admins.name as admin_name
                    from group_internal_box as boxd , driver ,admins  where  boxd.add_by = admins.id and boxd.foreign_type =? and foreign_id = driver.id and driver.id = ? and boxd.bond_type = 'take'
                    ;", [$directed_to , $id,]);
                    return $bonds;
                } else {
                    session()->flash('error', 'خطاء فى ارسال البيانات');
                    return false;
                }
        }
        public function show_add_driver(Driver $driver, Group $group)
        {

            if ($this->hasPermissionData($group->id) == false)
                   return back();
                if ($group->state == 'active')
                 {
                    $groupUser = GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $group->id)
                                            ->where('state', 'active')->get();

                    if (count($groupUser) > 0) {

                        return  view('groups.shared.driver.box.addBoxDriver', compact('driver','group'));
                    }
                    else {
                        session()->flash('status', 'جروب مستخدمين لايوجد بيانات');
                    }
                } else {
                    session()->flash('status', 'تم حظر الجروب الرجاء الروجع للإدارة' );
                }
                return back();
        }
        public function show_add_vechile(Vechile $vechile, Group $group)
        {

            if ($this->hasPermissionData($group->id) == false)
                   return back();
                if ($group->state == 'active')
                 {
                    $groupUser = GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $group->id)
                                            ->where('state', 'active')->get();

                    if (count($groupUser) > 0) {

                        return  view('groups.shared.vechile.box.addBoxVechile', compact('vechile','group'));
                    }
                    else {
                        session()->flash('status', 'جروب مستخدمين لايوجد بيانات');
                    }
                } else {
                    session()->flash('status', 'تم حظر الجروب الرجاء الروجع للإدارة' );
                }
                return back();
        }
        public function show_add_user(Admin $user, Group $group)
        {


            if ($this->hasPermissionData($group->id) == false)
                   return back();
                if ($group->state == 'active')
                 {
                    $groupUser = GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $group->id)
                                            ->where('state', 'active')->get();

                    if (count($groupUser) > 0) {
                        return  view('groups.shared.user.box.addBoxUser', compact('user','group'));
                    }
                    else {
                        session()->flash('status', 'جروب مستخدمين لايوجد بيانات');
                    }
                } else {
                    session()->flash('status', 'تم حظر الجروب الرجاء الروجع للإدارة' );
                }
                return back();
        }


        public function save_add_driver(Request $request, Driver $driver)
        {
            if ($this->hasPermissionData($driver->group_id) == false){
                return back();
            }
                $this->save_add($request, $driver->group_id);
                $totalMoney = $request->money + (($request->money * $request->tax) / 100);

                if ($request->bond_type == 'spend') {
                    $driver->group_balance -= $totalMoney;
                } else {
                    $driver->group_balance += $totalMoney;
                }
                $driver->save();
                $request->session()->flash('status', 'تم أضافة السند بنجاح');
                return redirect()->route("shared.groups.driver.box.show" , [ 'driver'=> $driver->id, 'group'=>$driver->group_id,'type' => $request->bond_type]);
        }
        public function save_add_vechile(Request $request, Vechile $vechile)
        {
            if ($this->hasPermissionData($vechile->group_id) == false){
                return back();
            }
                $this->save_add($request, $vechile->group_id);
                $totalMoney = $request->money + (($request->money * $request->tax) / 100);

                if ($request->bond_type == 'spend') {
                    $vechile->group_balance -= $totalMoney;
                } else {
                    $vechile->group_balance += $totalMoney;
                }
                $vechile->save();
                $request->session()->flash('status', 'تم أضافة السند بنجاح');
                return redirect()->route("shared.groups.vechile.box.show" , [ 'vechile'=> $vechile->id, 'group'=>$vechile->group_id,'type' => $request->bond_type]);
        }
        public function save_add_user(Request $request, Admin $user, Group $group)
        {
            $groupUser = GroupUser::where('user_id', $user->id)->where('group_id' , $group->id)->first();

            if ($this->hasPermissionData($group->id) == false){
                return back();
            }
                $this->save_add($request, $group->id);
                $totalMoney = $request->money + (($request->money * $request->tax) / 100);

                if ($request->bond_type == 'spend') {
                    $groupUser->group_balance -= $totalMoney;
                } else {
                    $groupUser->group_balance += $totalMoney;
                }
                $groupUser->save();
                $request->session()->flash('status', 'تم أضافة السند بنجاح');

                $user->group_balance = $groupUser->group_balance;
                return redirect()->route("shared.groups.user.box.show" , [ 'user'=> $user, 'groupUser' => $groupUser, 'group'=>$group,'type' => $request->bond_type]);
        }

        public function save_add(Request $request, $group_id)
        {
            $request->validate([
                'foreign_type' =>     'required|string|in:driver,vechile,user',
                'foreign_id' =>     'required|integer',
                'bond_type' =>  'required|string|in:take,spend',
                'payment_type' =>        'required|string|in:cash,bank transfer,internal transfer,selling points,electronic payment',
                'money' =>          'required|numeric',
                'tax' =>        'required|numeric',
                'descrpition' =>        'required|string',
            ]);

                $totalMoney = $request->money + (($request->money * $request->tax) / 100);
                $boxDriver = new \App\Models\Groups\GroupsInternalBox;
                $boxDriver->group_id = $group_id;
                $boxDriver->foreign_type = $request->foreign_type;
                $boxDriver->foreign_id = $request->foreign_id;
                $boxDriver->bond_type = $request->bond_type;
                $boxDriver->payment_type = $request->payment_type;
                $boxDriver->money = $request->money;
                $boxDriver->tax = $request->tax;
                $boxDriver->total_money = $totalMoney;

                $boxDriver->descrpition = $request->descrpition;
                $boxDriver->add_date = Carbon::now();
                $boxDriver->add_by = Auth::guard('admin')->user()->id;
                $boxDriver->save();

        }

        public function general_box_bonds(Group $group ,Request $request)
        {
            // return $group;

            $request->validate([
                'bonds' =>        'required|string',
            ]);

            $boxDate = '';
            if($request->id !== null){
                $boxDate = "and date(boxd.add_date) = '". $request->date."'";
            }else{
                $boxDate = "and date(boxd.add_date) = '". $request->date."'";
            }
                $sql =  "
                        select 'المجموعة' as type,  boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.add_date as deposit_date,
                        boxd.descrpition from group_internal_box as boxd left join groups as bondOwner on boxd.foreign_id = bondOwner.id
                        where boxd.foreign_type ='group' ".$boxDate." and boxd.group_id = ?  union all
                        select 'سائق' as type,  boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.add_date as deposit_date,
                        boxd.descrpition from group_internal_box as boxd left join driver as bondOwner on boxd.foreign_id = bondOwner.id
                        where boxd.foreign_type ='driver' ".$boxDate." and boxd.group_id = ? union all
                        select 'مركبة' as type,  boxd.id, bondOwner.plate_number ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.add_date as deposit_date,
                        boxd.descrpition from group_internal_box as boxd left join vechile as bondOwner on boxd.foreign_id = bondOwner.id
                        where boxd.foreign_type ='vechile' ".$boxDate." and boxd.group_id = ? union all
                        select 'مستخدم' as type,  boxd.id, bondOwner.name ,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.add_date as deposit_date,
                        boxd.descrpition from group_internal_box as boxd left join admins as bondOwner on boxd.foreign_id = bondOwner.id
                        where boxd.foreign_type ='user' ".$boxDate. " and boxd.group_id = ?";

            $bonds = DB::select($sql, [$group->id,$group->id,$group->id,$group->id]);
            return $bonds;
        }

    }
