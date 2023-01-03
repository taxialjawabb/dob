<?php

namespace App\Http\Controllers\Admin\Warning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class UserWarningController extends Controller
{
    public function update_date(Request $request)
    {
        $request->validate([
            'user_id' =>  'required|integer',
            'warning_type' =>        'required|string|in:Employment_contract_expiration_date,final_clearance_exity_date',
            'update_date' =>          'required|date'
        ]);
        $user = \App\Models\Admin::select(['id','name','Employment_contract_expiration_date','final_clearance_exity_date',])->find($request->user_id);

        if($user !== null){
            if($request->warning_type == 'Employment_contract_expiration_date'){
                $user->Employment_contract_expiration_date = $request->update_date;
                $user->save();
            }
            else if($request->warning_type == 'final_clearance_exity_date'){
                $user->final_clearance_exity_date = $request->update_date;
                $user->save();
            }
            $request->session()->flash('status', 'تم تحديث التاريخ بنجاح للمستخدم '. $user->name);
        }else{
            $request->session()->flash('error', 'خطاء فى بيانات المستخدم');
        }
        return back();
    }

    public function show($type)
    {
        if($type === 'Employment_contract_expiration_date'){
            $data = DB::select("select id, name, phone, state, created_at, Employment_contract_expiration_date as ended_date,
            DATEDIFF(Employment_contract_expiration_date , now()) as days from admins where state='active' and DATEDIFF(Employment_contract_expiration_date , now()) < 60  order by  days;");

            $contractClear   = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(Employment_contract_expiration_date , now()) > 60   ");
            $contractRemains = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(Employment_contract_expiration_date , now()) < 60 and  DATEDIFF(Employment_contract_expiration_date , now()) > 0   ");
            $contractExpired = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(Employment_contract_expiration_date , now()) < 0   ");

            $contractClear  = count($contractClear  ) > 0 ? $contractClear[0]->mycount: 0;
            $contractRemains = count($contractRemains) > 0 ? $contractRemains[0]->mycount: 0;
            $contractExpired = count($contractExpired) > 0 ? $contractExpired[0]->mycount: 0;

            $typeName = "انتهاء عقد العمل";
            return view('warning.userWarning', compact('data', 'type', 'contractClear' , 'contractRemains', 'contractExpired', 'typeName'));
        }
        else if($type === 'final_clearance_exity_date'){
            $data = DB::select("select id, name, phone, state, created_at, final_clearance_exity_date as ended_date,
            DATEDIFF(final_clearance_exity_date , now()) as days from admins where state='active' and DATEDIFF(final_clearance_exity_date , now()) < 60  order by  days;");


            $clearanceClear   = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(final_clearance_exity_date , now()) > 60   ");
            $clearanceRemains = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(final_clearance_exity_date , now()) < 60 and  DATEDIFF(final_clearance_exity_date , now()) > 0   ");
            $clearanceExpired = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(final_clearance_exity_date , now()) < 0   ");

            $clearanceClear  = count($clearanceClear  ) > 0 ? $clearanceClear[0]->mycount: 0;
            $clearanceRemains = count($clearanceRemains) > 0 ? $clearanceRemains[0]->mycount: 0;
            $clearanceExpired = count($clearanceExpired) > 0 ? $clearanceExpired[0]->mycount: 0;

            $typeName = "انتهاء المخالصة النهائية";
            return view('warning.userWarning', compact('data', 'type', 'clearanceClear' , 'clearanceRemains', 'clearanceExpired', 'typeName'));
        }
        else if($type === 'id_expiration_date'){
            $data = DB::select("select id, name, phone, state, created_at, id_expiration_date as ended_date,
            DATEDIFF(id_expiration_date , now()) as days from admins where state='active' and DATEDIFF(id_expiration_date , now()) < 60  order by  days;");


            $clearanceClear   = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(id_expiration_date , now()) > 60   ");
            $clearanceRemains = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(id_expiration_date , now()) < 60 and  DATEDIFF(id_expiration_date , now()) > 0   ");
            $clearanceExpired = DB::select("select count(id) as mycount from admins where state ='active' and  DATEDIFF(id_expiration_date , now()) < 0   ");

            $clearanceClear  = count($clearanceClear  ) > 0 ? $clearanceClear[0]->mycount: 0;
            $clearanceRemains = count($clearanceRemains) > 0 ? $clearanceRemains[0]->mycount: 0;
            $clearanceExpired = count($clearanceExpired) > 0 ? $clearanceExpired[0]->mycount: 0;

            $typeName = "انتهاء الإقامة";
            return view('warning.userWarning', compact('data', 'type', 'clearanceClear' , 'clearanceRemains', 'clearanceExpired', 'typeName'));
        }
        else{
            return back();
        }
    }
}
