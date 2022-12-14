<?php

namespace App\Http\Controllers\Admin\Nathiraat\Stakeholders;

use App\Http\Controllers\Controller;
use App\Models\Nathiraat\StakeholdersNotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Nathiraat\Stakeholders;
use Carbon\Carbon;

class StakeholdersController extends Controller
{
    public function show_stakeholders()
    {
        // return Auth::guard('admin')->user()->hasPermission('marketing') == false ? 'false': 'true';
        if( Auth::guard('admin')->user()->hasPermission('stakeholders')){
            $data =DB::select("select stakeholders.id , stakeholders.name,expire_date , admins.name as add_by , stakeholders.add_date from stakeholders, admins where stakeholders.add_by = admins.id ;");
            return view('nathiraat.stakeholders.showStakeholders',compact('data'));
        }
        else if(Auth::guard('admin')->user()->hasPermission('marketing')){
            $data =DB::select("select stakeholders.id , stakeholders.name,expire_date , admins.name as add_by , stakeholders.add_date from stakeholders, admins where stakeholders.add_by = admins.id and stakeholders.id = 11 ;" );
            return view('nathiraat.stakeholders.showStakeholders',compact('data'));
        }
        else{
            return back();
        }
    }

    public function add_show(){
        return view('nathiraat.stakeholders.addStakeholders');
    }
    public function add_save(Request $request){
        $request->validate([
            "name" => "required|string",
            "expire_date" => "required",
        ]);
        $stakeholders = new Stakeholders;
        $stakeholders->name  = $request->name ;
        $stakeholders->record_number  = $request->record_number ;
        $stakeholders->expire_date  = $request->expire_date ;
        $stakeholders->add_date = Carbon::now();
        $stakeholders->add_by = Auth::guard('admin')->user()->id;
        $stakeholders->save();
        $request->session()->flash('status', '???? ?????????? ?????????? ?????????????????? ??????????');
        return back();
    }

    public function update_show_stackhoder($id){

        $stakeholder = Stakeholders::find($id);
        if($stakeholder !== null){
            return view('nathiraat.stakeholders.updateStakeholders', compact('stakeholder'));
        }
        else{
            return back();
        }
    }

    public function update_save_stackhoder(Request $request){

        $request->validate([
            "id" => "required|integer",
            "name" => "required|string",
            "record_number" => "required|string",
            "expire_date" => "required|string",
            "commerical_register" => "required|string",
            "id_number" => "required|string",
            "license_number" => "required|string",
            "license_category" => "required|string",
            "phone" => "required|string",
            "address" => "required|string",
            "company_fax" => "required|string",
            "email" => "required|string",
        ]);
        $note='';
        $stakeholder = Stakeholders::find($request->id);
        if($stakeholder !== null){

            if($stakeholder->name !=$request->name)
            {
                 $note.=' ???? ??????????  ??????  ???? '.($stakeholder->name==null?' ???????? ':$stakeholder->name).'  ?????? '.$request->name;

            }
            $stakeholder->name = $request->name;

            if($stakeholder->record_number !=$request->record_number)
            {
                 $note.=' ???? ??????????  ?????? ?????????? ??????????????  ???? '.($stakeholder->record_number==null?' ???????? ':$stakeholder->record_number).'  ?????? '.$request->record_number;

            }
            $stakeholder->record_number = $request->record_number;

            if(date('Y-m-d', strtotime($stakeholder->expire_date))!=date('Y-m-d', strtotime($request->expire_date)))
            {
                $note.=' ???? ?????????? ??????????   ???????????????? ???????????????? ???? '.($stakeholder->expire_date==null?' ???????? ':$stakeholder->expire_date).' ?????? '.$request->expire_date;



            }
            $stakeholder->expire_date = $request->expire_date;
            if($stakeholder->commerical_register !=$request->commerical_register)
            {
                 $note.=' ???? ??????????  ?????? ?????????? ??????????????  ???? '.($stakeholder->commerical_register==null?' ???????? ':$stakeholder->commerical_register).'  ?????? '.$request->commerical_register;

            }
            $stakeholder->commerical_register = $request->commerical_register;
            if($stakeholder->id_number !=$request->id_number)
            {
                 $note.=' ???? ??????????  ?????? ???????? ??????????????  ???? '.($stakeholder->id_number==null?' ???????? ':$stakeholder->id_number).'  ?????? '.$request->id_number;

            }
            $stakeholder->id_number = $request->id_number;
            if($stakeholder->license_number !=$request->license_number)
            {
                 $note.=' ???? ??????????  ?????? ?????????????? ???? '.($stakeholder->license_number==null?' ???????? ':$stakeholder->license_number).'  ?????? '.$request->license_number;

            }
            $stakeholder->license_number = $request->license_number;
            if($stakeholder->license_category !=$request->license_category)
            {
                 $note.=' ???? ??????????  ?????? ??????????????  ???? '.($stakeholder->license_category==null?' ???????? ':$stakeholder->license_category).'  ?????? '.$request->license_category;

            }
            $stakeholder->license_category = $request->license_category;
            if($stakeholder->phone !=$request->phone)
            {
                 $note.=' ???? ??????????   ?????? ????????????    ???? '.($stakeholder->phone==null?' ???????? ':$stakeholder->phone).'  ?????? '.$request->phone;

            }
            $stakeholder->phone = $request->phone;
            if($stakeholder->address !=$request->address)
            {
                 $note.=' ???? ??????????  ??????????????  ???? '.($stakeholder->address==null?' ???????? ':$stakeholder->address).'  ?????? '.$request->address;

            }
            $stakeholder->address = $request->address;
            if($stakeholder->company_fax !=$request->company_fax)
            {
                 $note.=' ???? ??????????  ?????? ????????   ???? '.($stakeholder->company_fax==null?' ???????? ':$stakeholder->company_fax).'  ?????? '.$request->company_fax;

            }
            $stakeholder->company_fax = $request->company_fax;
            if($stakeholder->email !=$request->email)
            {
                 $note.=' ???? ??????????  ???????????? ????????????????????  ???? '.($stakeholder->email==null?' ???????? ':$stakeholder->email).'  ?????? '.$request->email;

            }

            $stakeholder->email = $request->email;
            if($note!=null)
            {
                $not = new StakeholdersNotes;
                $not->note_type = "?????????? ????????????";
                $not->content = $note;
                $not->add_date = Carbon::now();
                $not->admin_id = Auth::guard('admin')->user()->id;
                $not->nathriaat_id =$request->id;
                $not->save();
            }
            $stakeholder->save();
            $request->session()->flash('status', '???? ?????????? ?????????? ??????????');
        }
        else{
            $request->session()->flash('error', '?????? ???????? ???? ???????????????? ??????????????');
        }
        return back();

    }

    public function detials($id){
        if( Auth::guard('admin')->user()->hasPermission('stakeholders')){
            $data = DB::select("select stakeholders.id as id , stakeholders.name,expire_date , admins.name as add_by , stakeholders.add_date from stakeholders, admins where stakeholders.add_by = admins.id and stakeholders.id = ? limit 1;", [$id]);
            if(count($data) > 0){
                $stakeholder = $data[0];
                return view('nathiraat.stakeholders.detials',compact('stakeholder'));
            }
        }
        else if( Auth::guard('admin')->user()->hasPermission('marketing') && $id == 11 ){
            $data = DB::select("select stakeholders.id as id , stakeholders.name,expire_date , admins.name as add_by , stakeholders.add_date from stakeholders, admins where stakeholders.add_by = admins.id and stakeholders.id = 11 limit 1;");
            if(count($data) > 0){
                $stakeholder = $data[0];
                return view('nathiraat.stakeholders.detials',compact('stakeholder'));
            }
        }
        return back();
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
            "phone" => "required|numeric",
            "working_hours" => "required|numeric",
            "monthly_salary" => "required|numeric",
            "date_join" => "required",
            "Employment_contract_expiration_date" => "required",
            "final_clearance_exity_date" => "required",
        ]);
        $checkPhone = Admin::select('id')->where('phone', $request->phone)->where('id', '!=',$request->id)->get();
        $admin =  Admin::find($request->id);
        if(count($checkPhone) === 0){
            $admin->name  = $request->name ;
            $admin->phone  = $request->phone ;
            if($request->has('phone') && strlen($request->phone) > 5){
                $admin->password  = Hash::make($request->password);
            }
            $admin->working_hours  = $request->working_hours ;
            $admin->monthly_salary  = $request->monthly_salary ;
            $admin->date_join  = $request->date_join ;
            $admin->Employment_contract_expiration_date  = $request->Employment_contract_expiration_date ;
            $admin->final_clearance_exity_date  = $request->final_clearance_exity_date ;
            $admin->add_by = Auth::guard('admin')->user()->id;
            $admin->save();
            $admin->syncRoles([$request->role_id]);
            $request->session()->flash('status', '???? ?????????? ???????????????? ??????????');
        }else{
            $request->session()->flash('error', '???????????? ???????????? ???? ???????????????? ??????????????');
        }
        return back();
    }
}
