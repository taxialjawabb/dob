<?php

namespace App\Http\Controllers\Admin\Warning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartsWarningController extends Controller
{
    public function show()
    {
        $idClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) > 60   ");
        $idRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) < 60 and  DATEDIFF(id_expiration_date , now()) > 0   ");
        $idExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(id_expiration_date , now()) < 0   ");
        
        $licenseClear   = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) > 60   ");
        $licenseRemains = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 60 and  DATEDIFF(license_expiration_date , now()) > 0   ");
        $licenseExpired = DB::select("select count(id) as mycount from driver where  (state ='active' or state='waiting') and  DATEDIFF(license_expiration_date , now()) < 0   ");

        $idClear  = count($idClear  ) > 0 ? $idClear[0]->mycount: 0; 
        $idRemains = count($idRemains) > 0 ? $idRemains[0]->mycount: 0;
        $idExpired = count($idExpired) > 0 ? $idExpired[0]->mycount: 0;
    
        $licenseClear  = count($licenseClear  ) > 0 ? $licenseClear[0]->mycount: 0; 
        $licenseRemains = count($licenseRemains) > 0 ? $licenseRemains[0]->mycount: 0;
        $licenseExpired = count($licenseExpired) > 0 ? $licenseExpired[0]->mycount: 0;
    
        return view('warning.chartsDriverWarning', 
                    compact(
                        'idClear' ,
                        'idRemains',
                        'idExpired',
                        'licenseClear' ,
                        'licenseRemains',
                        'licenseExpired',
                    
                    ));
    }
}
