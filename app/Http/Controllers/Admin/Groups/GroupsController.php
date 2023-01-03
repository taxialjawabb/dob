<?php

namespace App\Http\Controllers\Admin\Groups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Groups\BoxGroup;
use App\Models\Groups\Group;
use App\Models\Groups\GroupBooking;
use App\Models\Groups\GroupUser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Nathiraat\BoxNathriaat;
use App\Models\Driver;
use App\Models\Vechile;
use App\Models\Admin;

class GroupsController extends Controller
{

    public function show()
    {
        $groups = Group::with('manager:id,name')->get();
        // return $groups[2]->manager->name;
        $vechilePrice = \App\Models\Groups\GroupVechilePrice::find(1);
        return view('groups.showGroups', compact('groups' ,'vechilePrice'));
    }

    public function update_vechile_price(Request $request)
    {
        $request->validate([
            'id' => ['required','numeric'],
            'vechile_price' => ['required', 'numeric']
        ]);
        \App\Models\Groups\GroupVechilePrice::where('id' , $request->id)->update([
            'vechile_price' => $request->vechile_price
        ]);
        return back();
    }

    //page add group

    //save group function


    public function show_details(Group $group)
    {
        return view('groups.detials', compact('group'));

    }

    public function show_vechile($id)
    {
        if($id == 'aljwab'){
            $vechiles =  \App\Models\Vechile::select(['id','vechile_type', 'made_in', 'plate_number', 'color', 'state', 'account', 'daily_revenue_cost', 'maintenance_revenue_cost', 'identity_revenue_cost'])->whereNull('group_id')->get();
            return view('groups.showGroupVechile', compact('vechiles', 'id'));
        }
        $group=null;
        if(Auth::user()->isAbleTo('manage_group'))
        {
            $group = Group::find($id);
        }
        else
        {
            $groupUser = GroupUser::where('user_id',Auth::guard('admin')->user()->id)->where('group_id',$id)->get();

            if(count($groupUser)>0){
                $group=Group::find($id);

            }
        }
        if($group !== null)
        {
            $vechiles = $group->vechiles;
            return view('groups.showGroupVechile', compact('vechiles','id'));
        }
        else{
            session()->flash('error', ' لابمكن الدخول الي هذه المجموعة');
            return back();
        }
    }

    public function add_vechile($id)
    {

        $group = GroupUser::where('user_id' ,Auth::guard('admin')->user()->id)->where('group_id', $id)->where('state', '=','active')->get();

        $user=Group::where('manager_id',Auth::guard('admin')->user()->id)->get();

        if(count($group)>0||count($user)>0||(Auth::user()->isAbleTo('manage_group')))
       {
                $cat= \App\Models\Category::select('id', 'category_name')->get();
                return view('groups.vechile.addVechile',compact('id','cat'));
       }
        session()->flash('error', ' لابمكن الدخول الي هذه المجموعة');
        return back();
    }

    public function save_vechile(Request $request)
    {

        $request->validate([
            'vechile_type' => ['required','string'],
            'made_in' => ['required','string'],
            'serial_number' => ['required','string'],
            'plate_number' => ['required','string'],
            'color' => ['required','string'],
            'driving_license_expiration_date' => ['required','date'],
            'insurance_card_expiration_date' => ['required','date'],
            'periodic_examination_expiration_date' => ['required','date'],
            'operating_card_expiry_date' => ['required','date'],
            'category_id' => ['required','integer'],
            'secondary_id' => ['required','integer'],
            // 'daily_revenue_cost' => ['required', 'numeric'],
            // 'maintenance_revenue_cost' => ['required', 'numeric'],
            // 'identity_revenue_cost' => ['required', 'numeric'],
            'registration_type' => ['required', 'string'],
            'operation_card_number' => ['required', 'string'],
            'fuel_type' => ['required', 'string'],
            'amount_fuel' => ['required', 'string'],
            'insurance_policy_number' => ['required', 'string'],
            'insurance_type' => ['required', 'string'],

        ]);


        $vec = Vechile::where('plate_number', $request->plate_number)->
        orWhere('serial_number', $request->serial_number)->get();

        if(count($vec) > 0){
            $request->session()->flash('error', 'الرجاء التأكد من رقم اللوحة او رقم التسلسلى');
            return back();
        }
        else{
            $vechile= new Vechile;
            $vechile->vechile_type = $request-> vechile_type;
            $vechile->made_in = $request-> made_in;
            $vechile->serial_number = $request-> serial_number;
            $vechile->plate_number = $request-> plate_number;
            $vechile->color = $request-> color;
            $vechile->driving_license_expiration_date = $request-> driving_license_expiration_date;
            $vechile->insurance_card_expiration_date = $request-> insurance_card_expiration_date;
            $vechile->periodic_examination_expiration_date = $request-> periodic_examination_expiration_date;
            $vechile->operating_card_expiry_date = $request-> operating_card_expiry_date;
            $vechile->category_id = $request-> category_id;
            $vechile->secondary_id = $request-> secondary_id;
            $vechile->daily_revenue_cost = 0;
            $vechile->maintenance_revenue_cost = 0;
            $vechile->identity_revenue_cost = 0;
            $vechile->registration_type = $request->registration_type;
            $vechile->operation_card_number = $request->operation_card_number;
            $vechile->fuel_type = $request->fuel_type;
            $vechile->amount_fuel = $request->amount_fuel;
            $vechile->insurance_policy_number = $request->insurance_policy_number;
            $vechile->insurance_type = $request->insurance_type;
            $vechile->add_date =  Carbon::now();
            $vechile->admin_id =  Auth::guard('admin')->user()->id;
            // return $request->stakeholder;
            if($request->stakeholder !== 0){
                if($request->stakeholder !== 1){
                    $group = \App\Models\Groups\Group::find($request->stakeholder);
                    if($group->vechile_counter > $group->added_vechile){
                        $group->added_vechile++;
                        $group->save();
                    }else{
                        $request->session()->flash('error', 'لا يمكنك أضافة مركبات فى هذه المجموع مكتملة');
                        return back();
                    }
                }
                $vechile->group_id = $request->stakeholder;
            }
            $vechile->save();
            $request->session()->flash('status', 'تم إضافة المركبة بنجاح');
            return redirect('groups/show/vechiles/'.$request->stakeholder);
            }
    }
    public function show_driver($id)
    {
        if($id === 'aljwab'){
            $drivers =  \App\Models\Driver::select([ 'id', 'name', 'nationality', 'state', 'phone', 'account' ])->whereNull('group_id')->get();
            $id=1;
            return view('groups.showGroupDriver', compact('drivers','id'));
        }
       $group=null;

       if(Auth::user()->isAbleTo('manage_group'))
       {
           $group = Group::find($id);
        }
        else
        {
            $groupUser = GroupUser::where('user_id',Auth::guard('admin')->user()->id)->where('group_id',$id)->get();
            if(count($groupUser)>0){
                $group=Group::find($id);

            }
        }


        if($group !== null)
        {
            $drivers = $group->drivers;

            return view('groups.showGroupDriver', compact('drivers','id'));
        }
        else
        {
            return back();
        }
    }
    public function add_driver($id)
    {

        $group = GroupUser::where('user_id' ,Auth::guard('admin')->user()->id)->where('group_id', $id)->where('state', '=','active')->get();

        $user=Group::where('manager_id',Auth::guard('admin')->user()->id)->get();

        if(count($group)>0||count($user)>0||(Auth::user()->isAbleTo('manage_group')))
         {
                return view('groups.driver.addDriver',compact('id'));
        }
        session()->flash('error', ' لابمكن الدخول الي هذه المجموعة');
        return back();
    }
    public function save_driver(Request $request)
    {

        $request->validate([
        "group_id" => 'required|string',
        "name" => 'required|string',
        "nationality" => 'required|string',
        "phone" => 'required|string',
        "address" => 'required|string',
        "ssd" => 'required|string',
        "id_copy_no" => 'required|string',
        "id_expiration_date" => 'required|string',
        "license_type" => 'required|string',
        "license_expiration_date" => 'required|string',
        "birth_date" => 'required|string',
        "start_working_date" => 'required|string',
        "contract_end_date" => 'required|string',
        "final_clearance_date" => 'required|string',
        ]);
        $driverData = Driver::where('ssd', $request->ssd)->orWhere('phone', $request->phone)->get();
        if (count($driverData) > 0) {
            $request->session()->flash('error', 'الرجاء التأكد من البيانات المدخلة');
            return back();
        } else {
            $driver = new Driver;
            $driver->name = $request->name;
            $driver->password = '0' ;
            $driver->nationality = $request->nationality;
            $driver->ssd = $request->ssd;
            $driver->address = $request->address;
            $driver->id_copy_no = $request->id_copy_no;
            $driver->id_expiration_date = $request->id_expiration_date;
            $driver->license_type = $request->license_type;
            $driver->license_expiration_date = $request->license_expiration_date;
            $driver->birth_date = $request->birth_date;
            $driver->start_working_date = $request->start_working_date;
            $driver->contract_end_date = $request->contract_end_date;
            $driver->final_clearance_date = $request->final_clearance_date;
            $driver->phone = $request->phone;
            $driver->admin_id = Auth::guard('admin')->user()->id;
            if ($request->stakeholder !== 0) {
                if ($request->stakeholder !== 1) {
                    $group = \App\Models\Groups\Group::find($request->group_id);
                    if ($group->vechile_counter > $group->added_driver) {
                        $group->added_driver++;
                        $group->save();
                    } else {
                        $request->session()->flash('error', 'لا يمكنك أضافة سائقين فى هذه المجموع مكتملة');
                        return back();
                    }
                }
                $driver->group_id = $request->group_id;
            }
            $driver->add_date = Carbon::now();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/drivers/personal_phonto'), $image);
                $driver->persnol_photo =  $image;
            }
            $driver->save();
            $request->session()->flash('status', 'تم إضافة السائق بنجاح');
            return redirect('groups/show/drivers/'.$request->group_id);
        }


    }
    public function show_user($id)
    {
        if($id === 'aljwab' || $id == 1){
            session()->flash('error', 'هذه المجموعة لا تحتوى على مستخدمين مسؤالين للإدارتها');
            return back();
        }


        $group = Group::find($id);
        if($group!==null)
        {

            if(Auth::user()->isAbleTo('manage_group')||$group->manager_id==Auth::guard('admin')->user()->id)
            {
                $users = $group->users;
                return view('groups.showGroupUser', compact('users','id'));
            }

        }

            session()->flash('error', ' لابمكن الدخول الي هذه المجموعة');
            return back();

    }
    public function change_state($id,$user_id)
    {
        $group=Group::find($id);
        if($group!=null)
        {
            if($group->manager_id==Auth::guard('admin')->user()->id)
            {

            $groupUser = GroupUser::where('user_id' ,$user_id)->where('group_id', $id)->get();

            if(count($groupUser)>0)
            {
                $groupUser[0]->state=$groupUser[0]->state==='active'?'blocked':'active';
                $groupUser[0]->save();
                return back();

            }

            }

        }

       return back();



    }
    public function add_user($id)
     {

    $user=Group::where('id',$id)->where('manager_id',Auth::guard('admin')->user()->id)->get();

    if(count($user)>0)
    {
       return view('groups.user.addUser',compact('id'));
    }
    session()->flash('error', ' لابمكن الدخول الي هذه المجموعة');
    return back();
     }
     public function save_user(Request $request){
        $request->validate([
            "name" => "required|string",
            "phone" => "required|numeric",
            "nationality" => "required|string",
            "ssd" => "required",
            "password" => "required",
            "working_hours" => "required|numeric",
            "monthly_salary" => "required|numeric",
            "date_join" => "required",
            "Employment_contract_expiration_date" => "required",
            "final_clearance_exity_date" => "required",
        ]);
        $checkPhone = Admin::select('id')->where('phone', $request->phone)->orWhere('ssd', $request->ssd)->get();
        if(count($checkPhone) === 0){
            $admin = new Admin;
            $admin->name  = $request->name ;
            $admin->phone  = $request->phone ;
            $admin->department  = 'group_manager' ;
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
            GroupUser::create([
                'user_id' => $admin->id,
                'group_id' => $request->group_id,
                'state' => 'active',
            ]);
            $request->session()->flash('status', 'تم إضافة المستخدم بنجاح');
            return redirect('groups/show/users/'.$request->group_id);
        }else{
            $request->session()->flash('error', 'الرجاء التأكد من البيانات المدخلة');
        }
               return back();
    }





}

