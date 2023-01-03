<?php

namespace App\Http\Controllers\Admin\Warning;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{
    public function show_contract()
    {
        $data = DB::select("select id, contract_number, car_plate_number, date(contract_end_datetime) as expire_date,
                            DATEDIFF(contract_end_datetime , now()) as days from contract where  DATEDIFF(contract_end_datetime , now()) < 60  order by  days;");

        $contractActive   = DB::select("select count(id) as mycount from contract where contract_status ='ساري' and  DATEDIFF(contract_end_datetime , now()) >0   ;");
        $contractCloseToExpired   = DB::select("select count(id) as mycount from contract where contract_status ='ساري' and  DATEDIFF(contract_end_datetime , now()) < 3 and DATEDIFF(contract_end_datetime , now()) >0;");
        $contractNotEnded = DB::select("select count(id) as mycount from contract where contract_status ='ساري' and  DATEDIFF(contract_end_datetime , now()) < 1   ;");
        $contractExpired = DB::select("select count(id) as mycount from contract where contract_status ='لاغي'  ;");


        $contractActive  = count($contractActive  ) > 0 ? $contractActive[0]->mycount: 0;
        $contractCloseToExpired  = count($contractCloseToExpired  ) > 0 ? $contractCloseToExpired[0]->mycount: 0;
        $contractNotEnded = count($contractNotEnded) > 0 ? $contractNotEnded[0]->mycount: 0;
        $contractExpired = count($contractExpired) > 0 ? $contractExpired[0]->mycount: 0;

        $typeName = "انتهاء العقود";
        return view('warning.contractWarning', compact(
                    'data',
                    'contractActive' ,
                    'contractCloseToExpired' ,
                    'contractNotEnded',
                    'contractExpired',
                    'typeName'));
    }
}
