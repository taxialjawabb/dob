<?php

namespace App\Http\Controllers\Admin\Groups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Groups\Group;
use App\Models\Groups\GroupUser;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class GroupsUserController extends Controller
{
    public function show($id)
    {
        $groups = Auth::guard('admin')->user()->groups;

        if($groups !== null){
            return redirect('my/groups/show');
        }
        else{
            return back();
        }
    }

    public function driver_show($id, $groupid)
    {
        $group = GroupUser::where('user_id' , Auth::guard('admin')->user()->id)->where('group_id', $groupid)->get();
        if(count($group) > 0||(Auth::user()->isAbleTo('manage_group'))){
            $driver = \App\Models\Driver::find($id);
            if($driver != null){
                $vechile = \App\Models\Vechile::find($driver->current_vechile);
                return view('groups.driver.detials', compact('driver', 'vechile'));
            }
        }
        return back();
    }
    public function vechile_show($id,$groupid)
    {

        $group = GroupUser::where('user_id' ,Auth::guard('admin')->user()->id)->where('group_id', $groupid)->get();


        if(count($group) > 0||(Auth::user()->isAbleTo('manage_group'))){
            $vechile = \App\Models\Vechile::with('added_by')->with('category')->with('secondary_category')->find($id);
            // return $vechile;
            return view('groups.shared.vechile.detials', compact('vechile'));

        }
        return back();
    }
    public function user_show($groupid,$id)
    {

         $userData=Group::where('manager_id',Auth::guard('admin')->user()->id)->where('id',$groupid)->get();

        if(count($userData) > 0||Auth::user()->isAbleTo('manage_group')){
            $user = Admin::find($id);
            if($user!==null)
             {
                return view('groups.shared.user.detials', compact('user'));
             }



        }
        return back();
    }
    public function add_save(Request $request){
        $request->validate([
            "name" => "required|string",
            "phone" => "required|numeric",
            "department" => "required|string",
            "nationality" => "required|string",
            "ssd" => "required",
            "password" => "required",
            "working_hours" => "required|numeric",
            "monthly_salary" => "required|numeric",
            "date_join" => "required",
            "Employment_contract_expiration_date" => "required",
            "final_clearance_exity_date" => "required",
        ]);
        $checkPhone =Admin::select('id')->where('phone', $request->phone)->orWhere('ssd', $request->ssd)->get();
        if(count($checkPhone) === 0){
            $admin = new Admin;
            $admin->name  = $request->name ;
            $admin->phone  = $request->phone ;
            $admin->department  = $request->department ;
            $admin->nationality  = $request->nationality ;
            $admin->ssd  = $request->ssd ;
            $admin->password  = \Illuminate\Support\Facades\Hash::make($request->password);
            $admin->working_hours  = $request->working_hours ;
            $admin->monthly_salary  = $request->monthly_salary ;
            $admin->date_join  = $request->date_join ;
            $admin->Employment_contract_expiration_date  = $request->Employment_contract_expiration_date ;
            $admin->final_clearance_exity_date  = $request->final_clearance_exity_date ;
            $admin->add_by = Auth::guard('admin')->user()->id;
            $admin->save();
            $admin->syncPermissions(['user_group']);
            $request->session()->flash('status', 'تم إضافة المستخدم بنجاح');
        }else{
            $request->session()->flash('error', 'الرجاء التأكد من البيانات المدخلة');
        }
        return back();
    }
}
