<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User\UserDocuments;
use App\Models\User\BoxUser;
use App\Models\User\UserNotes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function show_users($type)
    {
        if($type == 'active' || $type =='blocked'){

            $users =DB::select("select users.id, users.name , users.phone, users.created_at, ad.name as add_by
                                from admins as users left join admins as ad on users.add_by = ad.id where users.state =?;", [$type]);
            // $users = Admin::leftJoin('admins', 'admins.id', '=', ' admins.id')
            // ->get();
            $data = [];
            for ($i=0; $i < count($users) ; $i++) {
                    $admin = new Admin;
                    $admin->id = $users[$i]->id;
                    $admin->name = $users[$i]->name;
                    $admin->phone = $users[$i]->phone;
                    $admin->created_at = $users[$i]->created_at;
                    $admin->add_by = $users[$i]->add_by;
                    $data[$i] = $admin;
            }

            //return dd($data);
            return view('admin.users.showUser',compact('data' , 'type'));
        }
        else{
            return back();
        }
    }
 public function show_users_report()
 {
    $data = Admin::select(['name','state','nationality', 'ssd',
    'Employment_contract_expiration_date'])->get();
    return view('admin.users.showReportsView', compact('data'));
 }
    public function add_show(Request $request){
        $roles = \App\Models\Role::all();
        return view('admin.users.addUser', compact('roles'));
    }
    public function add_save(Request $request){
        $request->validate([
            "name" => "required|string",
            "phone" => "required|numeric",
            "department" => "required|string",
            "nationality" => "required|string",
            "ssd" => "required",
            "password" => "required",
            "working_hours" => "nullable|numeric",
            "monthly_salary" => "nullable|numeric",
            "monthly_deduct" => "nullable|numeric",
            "vacation_days" => "nullable|numeric",
            "date_join" => "required",
            "Employment_contract_expiration_date" => "required",
            "final_clearance_exity_date" => "required",
            "id_expiration_date" => "required",
        ]);
        // return $request->all();

        $checkPhone = Admin::select('id')->where('phone', $request->phone)->orWhere('ssd', $request->ssd)->get();
        if(count($checkPhone) === 0){
            $admin = new Admin;
            $admin->name  = $request->name ;
            $admin->phone  = $request->phone ;
            $admin->department  = $request->department ;
            $admin->nationality  = $request->nationality ;
            $admin->ssd  = $request->ssd ;
            $admin->password  = Hash::make($request->password);
            $admin->working_hours  = $request->working_hours ;
            $admin->monthly_salary  = $request->monthly_salary ;
            $admin->monthly_deduct  = $request->monthly_deduct ;
            $admin->vacation_days  = $request->vacation_days ? $request->vacation_days : 0 ;
            $admin->vacation_days_remains  = $request->vacation_days ? $request->vacation_days : 0;
            $admin->date_join  = $request->date_join ;
            $admin->Employment_contract_expiration_date  = $request->Employment_contract_expiration_date ;
            $admin->id_expiration_date  = $request->id_expiration_date ;
            $admin->final_clearance_exity_date  = $request->final_clearance_exity_date ;
            $admin->add_by = Auth::guard('admin')->user()->id;
            $admin->save();
            $admin->syncRoles([$request->role_id]);
            $request->session()->flash('status', 'تم إضافة المستخدم بنجاح');
            return redirect('user/show/active');
        }else{
            $request->session()->flash('error', 'الرجاء التأكد من البيانات المدخلة');
        }
        return back();
    }

    public function detials($id){
        $user = Admin::find($id);
        if($user !== null){
            $take= DB::table('box_user')
            ->where('bond_type', '=', 'take')
            ->where('user_id', '=', $id)
            ->sum('total_money');
            $spend= DB::table('box_user')
            ->where('bond_type', '=', 'spend')
            ->where('user_id', '=', $id)
            ->sum('total_money');
            $box=BoxUser::where('user_id',$id)->get();
            $documents=UserDocuments::where('user_id',$id)->get();
            return view('admin.users.detials',compact('user','box','documents','take','spend'));
        }else{
            return redirect('user/show');
        }
    }

    public function update_show($id)
    {
        $user = Admin::find($id);
        if($user !== null){
            $roles = \App\Models\Role::all();
            return view('admin.users.updateUser',compact('user','roles'));
        }else{
            return redirect('user/show');
        }
    }

    public function update_save(Request $request)
    {
        $request->validate([
            "id" => "required|integer",
            "name" => "required|string",
            "department" => "required|string",
            "phone" => "required|numeric",
            "working_hours" => "nullable|numeric",
            "monthly_salary" => "nullable|numeric",
            "monthly_deduct" => "nullable|numeric",
            "vacation_days" => "nullable|numeric",
            "date_join" => "required",
            "Employment_contract_expiration_date" => "required",
            "final_clearance_exity_date" => "required",
        ]);
        $note='';
        $checkPhone = Admin::select('id')->where('phone', $request->phone)->where('id', '!=',$request->id)->get();
        $admin =  Admin::find($request->id);
        if(count($checkPhone) === 0){
            if($admin->name !=$request->name)
            {
                 $note.=' تم تغيير اسم المستخدم من '.($admin->name==null?' فارغ ':$admin->name).'  الي '.$request->name;

            }
            $admin->name  = $request->name ;
            if($admin->department !=$request->department)
            {
                 $note.=' تم تغيير قسم المستخدم من '.($admin->department==null?' فارغ ':$admin->department).'  الي '.$request->department;

            }
            $admin->department  = $request->department ;
            if($admin->phone !=$request->phone)
            {
                 $note.=' تم تغيير رقم جوال المستخدم من '.($admin->phone==null?' فارغ ':$admin->phone).'  الي '.$request->phone;

            }
            $admin->phone  = $request->phone ;
            if($request->password !== null && strlen($request->password) > 5){
                if($request->password !=null)
            {
                 $note.=' تم تغيير رقم السري ل المستخدم  ';

            }
                $admin->password  = Hash::make($request->password);
            }
            if($admin->working_hours !=$request->working_hours)
            {
                 $note.=' تم تغيير  ساعات العمل ل المستخدم من '.($admin->working_hours==null?' فارغ ':$admin->working_hours).'  الي '.$request->working_hours;

            }
            $admin->working_hours  = $request->working_hours ;
            if($admin->monthly_salary !=$request->monthly_salary)
            {
                 $note.=' تم تغيير  الراتب الشهري  ل المستخدم من '.($admin->monthly_salary==null?' فارغ ':$admin->monthly_salary).'  الي '.$request->monthly_salary;

            }
            $admin->monthly_salary  = $request->monthly_salary ;
            if($admin->monthly_deduct !=$request->monthly_deduct)
            {
                 $note.=' تم تغيير  الاستقطاع الشهري  ل المستخدم من '.($admin->monthly_deduct==null?' فارغ ':$admin->monthly_deduct).'  الي '.$request->monthly_deduct;

            }

            $admin->monthly_deduct  = $request->monthly_deduct ;

            if($admin->vacation_days !=$request->vacation_days)
            {
                $admin->vacation_days_remains  -=  $admin->vacation_days - $request->vacation_days  ;
                // return $admin->vacation_days_remains ."==" .$admin->vacation_days ."==". $request->vacation_days;
                 $note.=' تم تغيير الاجازه السنوية  ل المستخدم من '.($admin->vacation_days==null?' فارغ ':$admin->vacation_days).'  الي '.$request->vacation_days;

            }
            $admin->vacation_days  = $request->vacation_days ;

            if(date('Y-m-d', strtotime($admin->date_join))!=date('Y-m-d', strtotime($request->date_join)))
            {
                $note.=' تم تغيير تاريخ  الانضمام من '.($admin->date_join==null?' فارغ ':$admin->date_join).' الي '.$request->date_join;



            }
            $admin->date_join  = $request->date_join ;
            if(date('Y-m-d', strtotime($admin->Employment_contract_expiration_date ))!=date('Y-m-d', strtotime($request->Employment_contract_expiration_date)))
            {
                $note.=' تم تغيير تاريخ  انتهاء العقد من '.($admin->Employment_contract_expiration_date==null?' فارغ ':$admin->Employment_contract_expiration_date).' الي '.$request->Employment_contract_expiration_date;



            }
            $admin->Employment_contract_expiration_date  = $request->Employment_contract_expiration_date ;
            if(date('Y-m-d', strtotime($admin->final_clearance_exity_date ))!=date('Y-m-d', strtotime($request->final_clearance_exity_date)))
            {
                $note.=' تم تغيير تاريخ إنتهاء المخالصة  من '.($admin->final_clearance_exity_date==null?' فارغ ':$admin->final_clearance_exity_date).' الي '.$request->final_clearance_exity_date;
            }
            $admin->final_clearance_exity_date  = $request->final_clearance_exity_date ;
            if(date('Y-m-d', strtotime($admin->id_expiration_date ))!=date('Y-m-d', strtotime($request->id_expiration_date)))
            {
                $note.=' تم تغيير تاريخ إنتهاء الإقامة  من '.($admin->id_expiration_date==null?' فارغ ':$admin->id_expiration_date).' الي '.$request->id_expiration_date;
            }
            $admin->id_expiration_date  = $request->id_expiration_date ;


            if($note!=null)
            {
                $not = new UserNotes;
                $not->note_type = 'تعديل بيانات';
                $not->content = $note;
                $not->add_date = Carbon::now();
                $not->admin_id = Auth::guard('admin')->user()->id;
                $not->user_id = $admin->id;
                $not->save();
            }
            // $admin->add_by = Auth::guard('admin')->user()->id;
            $admin->save();
            $admin->syncRoles([$request->role_id]);
            $request->session()->flash('status', 'تم تعديل المستخدم بنجاح');
        }else{
            $request->session()->flash('error', 'الرجاء التأكد من البيانات المدخلة');
        }
        return back();
    }

    public function activity_log()
    {
        $data = DB::select('select activity_log.id, activity_log.created_at, activity_log.log_type, activity_log.ip, admins.name from activity_log , admins where activity_log.admin_id = admins.id;');

        return view('admin.users.showUsersLogs', compact('data'));
    }

}
