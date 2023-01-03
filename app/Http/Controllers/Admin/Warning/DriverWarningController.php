<?php

namespace App\Http\Controllers\Admin\Warning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DriverWarningController extends Controller
{
    public function update_date(Request $request)
    {
        $request->validate([
            'driver_id' =>  'required|integer',
            'warning_type' =>        'required|string|in:id_expiration_date,license_expiration_date,contract_end_date,final_clearance_date',
            'update_date' =>          'required|date'
        ]);
        $driver = \App\Models\Driver::select(['id','name','id_expiration_date','license_expiration_date','contract_end_date','final_clearance_date'])->find($request->driver_id);

        if($driver !== null){
            if($request->warning_type == 'id_expiration_date'){
                $driver->id_expiration_date = $request->update_date;
                $driver->save();
            }
            else if($request->warning_type == 'license_expiration_date'){
                $driver->license_expiration_date = $request->update_date;
                $driver->save();
            }
            else if($request->warning_type == 'contract_end_date'){
                $driver->contract_end_date = $request->update_date;
                $driver->save();
            }
            else if($request->warning_type == 'final_clearance_date'){
                $driver->final_clearance_date = $request->update_date;
                $driver->save();
            }
            $request->session()->flash('status', 'تم تحديث التاريخ بنجاح للسائق '. $driver->name);
        }else{
            $request->session()->flash('error', 'خطاء فى بيانات السائق');
        }
        return back();
    }

    public function show($type)
    {
        if($type === 'id_expiration_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, id_expiration_date as ended_date, DATEDIFF(id_expiration_date , now()) as days from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) < 60  order by  days ;");

            $idClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) > 60   ");
            $idRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) < 60 and  DATEDIFF(id_expiration_date , now()) > 0   ");
            $idExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) < 0   ");

            $idClear  = count($idClear  ) > 0 ? $idClear[0]->mycount: 0;
            $idRemains = count($idRemains) > 0 ? $idRemains[0]->mycount: 0;
            $idExpired = count($idExpired) > 0 ? $idExpired[0]->mycount: 0;
            $typeName = "انتهاء الهوية";
            return view('warning.driverWarning', compact(
                'drivers',
                'type',
                'idClear' ,
                'idRemains',
                'idExpired',
                'typeName'
            ));
        }
        else if($type === 'license_expiration_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, license_expiration_date as ended_date, DATEDIFF(license_expiration_date , now()) as days from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 60  order by  days ;");

            $licenseClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) > 60   ");
            $licenseRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 60 and  DATEDIFF(license_expiration_date , now()) > 0   ");
            $licenseExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 0   ");

            $licenseClear  = count($licenseClear  ) > 0 ? $licenseClear[0]->mycount: 0;
            $licenseRemains = count($licenseRemains) > 0 ? $licenseRemains[0]->mycount: 0;
            $licenseExpired = count($licenseExpired) > 0 ? $licenseExpired[0]->mycount: 0;
            $typeName = "انتهاء الرخصة";
            return view('warning.driverWarning', compact('drivers', 'type', 'licenseClear' , 'licenseRemains', 'licenseExpired', 'typeName'));
        }
        else if($type === 'contract_end_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, contract_end_date as ended_date, DATEDIFF(contract_end_date , now()) as days from driver where (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) < 60  order by  days ;");

            $contractClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) > 60   ");
            $contractRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) < 60 and  DATEDIFF(contract_end_date , now()) > 0   ");
            $contractExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) < 0   ");

            $contractClear  = count($contractClear  ) > 0 ? $contractClear[0]->mycount: 0;
            $contractRemains = count($contractRemains) > 0 ? $contractRemains[0]->mycount: 0;
            $contractExpired = count($contractExpired) > 0 ? $contractExpired[0]->mycount: 0;
            $typeName = "انتهاء عقد العمل";
            return view('warning.driverWarning', compact('drivers', 'type', 'contractClear' , 'contractRemains', 'contractExpired', 'typeName'));
        }
        else if($type === 'final_clearance_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, final_clearance_date as ended_date, DATEDIFF(final_clearance_date , now()) as days from driver where (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) < 60  order by  days ;");

            $clearanceClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) > 60   ");
            $clearanceRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) < 60 and  DATEDIFF(final_clearance_date , now()) > 0   ");
            $clearanceExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) < 0   ");

            $clearanceClear   = count($clearanceClear  ) > 0 ? $clearanceClear[0]->mycount: 0;
            $clearanceRemains = count($clearanceRemains) > 0 ? $clearanceRemains[0]->mycount: 0;
            $clearanceExpired = count($clearanceExpired) > 0 ? $clearanceExpired[0]->mycount: 0;
            $typeName = "انتهاء المخالصة النهائية";
            return view('warning.driverWarning', compact('drivers', 'type', 'clearanceClear' , 'clearanceRemains', 'clearanceExpired', 'typeName'));
        }
        else{
            return back();
        }
    }
}
