<?php

namespace App\Http\Controllers\Admin\Groups\SharedGroups;

use App\Http\Controllers\Controller;
use App\Models\Groups\Group;
use DB;
use Illuminate\Http\Request;

class WariningGroupsController extends Controller
{


    public function show_driver_warning($type, $id)
    {
     
        if ($this->hasPermissionData($id) == false)
                   return back(); 
                   $group = Group::find($id);  
        if($type === 'id_expiration_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, id_expiration_date as ended_date, DATEDIFF(id_expiration_date , now()) as days from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) < 60  and group_id = ? order by  days ;", [$id]);

            $idClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) > 60   and group_id = ?  ", [$id]);
            $idRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) < 60 and  DATEDIFF(id_expiration_date , now()) > 0   and group_id = ?  ", [$id]);
            $idExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) < 0   and group_id = ?  ", [$id]);

            $idClear  = count($idClear  ) > 0 ? $idClear[0]->mycount: 0;
            $idRemains = count($idRemains) > 0 ? $idRemains[0]->mycount: 0;
            $idExpired = count($idExpired) > 0 ? $idExpired[0]->mycount: 0;

            return view('groups.shared.warning.driverWarning', compact(
                'drivers',
                'type',
                'idClear' ,
                'idRemains',
                'idExpired',
                'id',
                'group'

            ));
        }
        else if($type === 'license_expiration_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, license_expiration_date as ended_date, DATEDIFF(license_expiration_date , now()) as days from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 60  and group_id = ?  order by  days ;", [$id]);

            $licenseClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) > 60   and group_id = ?  ", [$id]);
            $licenseRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 60 and  DATEDIFF(license_expiration_date , now()) > 0   and group_id = ?  ", [$id]);
            $licenseExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 0   and group_id = ?  ", [$id]);

            $licenseClear  = count($licenseClear  ) > 0 ? $licenseClear[0]->mycount: 0;
            $licenseRemains = count($licenseRemains) > 0 ? $licenseRemains[0]->mycount: 0;
            $licenseExpired = count($licenseExpired) > 0 ? $licenseExpired[0]->mycount: 0;
            return view('groups.shared.warning.driverWarning', compact('drivers', 'type', 'licenseClear' ,'group', 'licenseRemains', 'licenseExpired', 'id'));
        }
        else if($type === 'contract_end_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, contract_end_date as ended_date, DATEDIFF(contract_end_date , now()) as days from driver where (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) < 60  and group_id = ?  order by  days ;", [$id]);

            $contractClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) > 60  and group_id = ?   ", [$id]);
            $contractRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) < 60 and  DATEDIFF(contract_end_date , now()) > 0  and group_id = ?   ", [$id]);
            $contractExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(contract_end_date , now()) < 0   and group_id = ?  ", [$id]);

            $contractClear  = count($contractClear  ) > 0 ? $contractClear[0]->mycount: 0;
            $contractRemains = count($contractRemains) > 0 ? $contractRemains[0]->mycount: 0;
            $contractExpired = count($contractExpired) > 0 ? $contractExpired[0]->mycount: 0;
            return view('groups.shared.warning.driverWarning', compact('drivers', 'type', 'group','contractClear' , 'contractRemains', 'contractExpired', 'id'));
        }
        else if($type === 'final_clearance_date'){
            $drivers = DB::select("select id, name, phone, state, add_date, final_clearance_date as ended_date, DATEDIFF(final_clearance_date , now()) as days from driver where (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) < 60  and group_id = ?  order by  days ;", [$id]);

            $clearanceClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) > 60  and group_id = ?   ", [$id]);
            $clearanceRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) < 60 and  DATEDIFF(final_clearance_date , now()) > 0   and group_id = ?  ", [$id]);
            $clearanceExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(final_clearance_date , now()) < 0   and group_id = ?  ", [$id]);

            $clearanceClear  = count($clearanceClear  ) > 0 ? $clearanceClear[0]->mycount: 0;
            $clearanceRemains = count($clearanceRemains) > 0 ? $clearanceRemains[0]->mycount: 0;
            $clearanceExpired = count($clearanceExpired) > 0 ? $clearanceExpired[0]->mycount: 0;
            return view('groups.shared.warning.driverWarning', compact('drivers', 'type', 'group','clearanceClear' , 'clearanceRemains', 'clearanceExpired', 'id'));
        }
        else{
            return back();
        }
    }

    public function show_vechile_warning($type, $id)
    {

        if ($this->hasPermissionData($id) == false)
                   return back();
        $group = Group::find($id);       
        if($type === 'driving_license_expiration_date'){
            $vechiles = DB::select("select id, vechile_type, made_in, plate_number, group_id , add_date, driving_license_expiration_date as ended_date,
            DATEDIFF(driving_license_expiration_date , now()) as days from vechile where (state ='active' or state='waiting') and  DATEDIFF(driving_license_expiration_date , now()) < 60 and group_id = ? order by  days;", [$id]);

            $licenseClear   = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(driving_license_expiration_date , now()) > 60   and group_id = ?  ", [$id]);
            $licenseRemains = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(driving_license_expiration_date , now()) < 60 and  DATEDIFF(driving_license_expiration_date , now()) > 0   < 5 and group_id = ?  ", [$id]);
            $licenseExpired = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(driving_license_expiration_date , now()) < 0  and group_id = ?  ", [$id]);

            $licenseClear  = count($licenseClear  ) > 0 ? $licenseClear[0]->mycount: 0;
            $licenseRemains = count($licenseRemains) > 0 ? $licenseRemains[0]->mycount: 0;
            $licenseExpired = count($licenseExpired) > 0 ? $licenseExpired[0]->mycount: 0;

            return view('groups.shared.warning.vechileWarning', compact('vechiles', 'type', 'licenseClear' , 'licenseRemains', 'licenseExpired', 'id','group'));
        }
        else if($type === 'insurance_card_expiration_date'){
            $vechiles = DB::select("select id, vechile_type, made_in, plate_number, group_id , add_date, insurance_card_expiration_date as ended_date,
            DATEDIFF(insurance_card_expiration_date , now()) as days from vechile where (state ='active' or state='waiting') and  DATEDIFF(insurance_card_expiration_date , now()) < 60 and group_id = ?  order by  days;", [$id]);

            $insuranceClear   = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(insurance_card_expiration_date , now()) > 60  and group_id = ?  ", [$id]);
            $insuranceRemains = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(insurance_card_expiration_date , now()) < 60 and  DATEDIFF(insurance_card_expiration_date , now()) > 0   < 5 and group_id = ?  ", [$id]);
            $insuranceExpired = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(insurance_card_expiration_date , now()) < 0  and group_id = ?  ", [$id]);

            $insuranceClear  = count($insuranceClear  ) > 0 ? $insuranceClear[0]->mycount: 0;
            $insuranceRemains = count($insuranceRemains) > 0 ? $insuranceRemains[0]->mycount: 0;
            $insuranceExpired = count($insuranceExpired) > 0 ? $insuranceExpired[0]->mycount: 0;
            return view('groups.shared.warning.vechileWarning', compact('vechiles', 'type', 'insuranceClear' , 'insuranceRemains', 'insuranceExpired', 'id','group'));
        }
        else if($type === 'periodic_examination_expiration_date'){
            $vechiles = DB::select("select id, vechile_type, made_in, plate_number, group_id , add_date, periodic_examination_expiration_date as ended_date,
            DATEDIFF(periodic_examination_expiration_date , now()) as days from vechile where (state ='active' or state='waiting') and  DATEDIFF(periodic_examination_expiration_date , now()) < 60  and group_id = ?  order by  days;", [$id]);

            $examinationClear   = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(periodic_examination_expiration_date , now()) > 60   and group_id = ?  ", [$id]);
            $examinationRemains = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(periodic_examination_expiration_date , now()) < 60 and  DATEDIFF(periodic_examination_expiration_date , now()) > 0   and group_id = ?  ", [$id]);
            $examinationExpired = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(periodic_examination_expiration_date , now()) < 0   and group_id = ?  ", [$id]);

            $examinationClear  = count($examinationClear  ) > 0 ? $examinationClear[0]->mycount: 0;
            $examinationRemains = count($examinationRemains) > 0 ? $examinationRemains[0]->mycount: 0;
            $examinationExpired = count($examinationExpired) > 0 ? $examinationExpired[0]->mycount: 0;
            return view('groups.shared.warning.vechileWarning', compact('vechiles', 'type', 'examinationClear' , 'examinationRemains', 'examinationExpired', 'id','group'));
        }
        else if($type === 'operating_card_expiry_date'){
            $vechiles = DB::select("select id, vechile_type, made_in, plate_number, group_id , add_date, operating_card_expiry_date as ended_date,
            DATEDIFF(operating_card_expiry_date , now()) as days from vechile where (state ='active' or state='waiting') and  DATEDIFF(operating_card_expiry_date , now()) < 5  and group_id = ?  order by  days;", [$id]);

            $operatingClear   = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(operating_card_expiry_date , now()) > 60  and group_id = ?   ", [$id]);
            $operatingRemains = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(operating_card_expiry_date , now()) < 60 and  DATEDIFF(operating_card_expiry_date , now()) > 0   and group_id = ?  ", [$id]);
            $operatingExpired = DB::select("select count(id) as mycount from vechile where (state ='active' or state='waiting') and  DATEDIFF(operating_card_expiry_date , now()) < 0   and group_id = ?  ", [$id]);

            $operatingClear  = count($operatingClear  ) > 0 ? $operatingClear[0]->mycount: 0;
            $operatingRemains = count($operatingRemains) > 0 ? $operatingRemains[0]->mycount: 0;
            $operatingExpired = count($operatingExpired) > 0 ? $operatingExpired[0]->mycount: 0;
            return view('groups.shared.warning.vechileWarning', compact('vechiles', 'type', 'operatingClear' , 'operatingRemains', 'operatingExpired', 'id','group'));
        }
        else{
            return back();
        }
    }
    
   
  
}
