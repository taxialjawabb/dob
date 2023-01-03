<?php

namespace App\Http\Controllers\Api\Transfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Http;

class TransferController extends Controller
{
    use GeneralTrait;
    public function check_transfer_rider(Request $request)
    {
        $request->validate([
            'rider_id'   => 'required|string',
            'type'    => 'required|string|in:driver,rider',
            'phone'    => 'required|string|min:10|max:10',
            'money'   => 'required|numeric',
            'phone_id'    => 'required|string'
        ]);
        $rider = \App\Models\Rider::select(['id','phone', 'account'])->find($request->rider_id);
        if($rider === null){
            return $this->returnError('E005',"حدث خطاء ما الرجاء المحاولة مرة اخرى");
        }
        if($request->type === 'driver'){
            $data = \App\Models\Driver::select(['id', 'name', 'phone'])
                                        ->where("phone" , $request->phone)->get();
            if(count($data) > 0){
                if($rider->account > $request->money){
                    // $job = $request->type === 'driver'? 'السائق' : 'العميل';
                    $message ="مرحبا عميل الجواب تفعيل عملية تحويل رصيد الرمز ";
                    $code = $this->send_code($rider->phone, $message , $request->phone_id );
                    if($code !== false){
                        $data[0]->code = $code;
                        return $this -> returnData('data' , $data[0], 'driver data'); 
                    }else{
                        return $this->returnError('', "verification code has not sent ");
                    } 
                }else{
                    return $this->returnError('E001',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('E002',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");

            }
        }
        else if($request->type === 'rider')
        {
            $data = \App\Models\Rider::select(['id', 'name', 'phone'])
                                        ->where("phone" , $request->phone)->get();
            if(count($data) > 0){
                if($rider->account > $request->money){
                    // $job = $request->type === 'driver'? 'السائق' : 'العميل';
                    $message ="مرحبا عميل الجواب عملية تحويل رصيد الرمز ";
                    $code = $this->send_code($rider->phone, $message , $request->phone_id );
                    if($code !== false){
                        $data[0]->code = $code;
                        return $this -> returnData('data' , $data[0], 'rider data'); 
                    }else{
                        return $this->returnError('', "verification code has not sent ");
                    }   
                }else{
                    return $this->returnError('E001',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('E002',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");

            }
        }
        else{
            return $this->returnError('E003',"الرجاء التأكد من الجهة المحول لها  ");
        }
        
    }

    public function check_transfer_driver(Request $request)
    {
        $request->validate([
            'driver_id'   => 'required|string',
            'type'    => 'required|string|in:driver,rider',
            'phone'    => 'required|string|min:10|max:10',
            'money'   => 'required|numeric',
            'phone_id'    => 'required|string'
        ]);
        $driver = \App\Models\Driver::select(['id', 'phone', 'account'])->find($request->driver_id);
        if($driver === null){
            return $this->returnError('00080',"حدث خطاء ما الرجاء المحاولة مرة اخرى");
        }
        if($request->type === 'driver'){
            $dataDriver = \App\Models\Driver::select(['name', 'phone'])
                                        ->where("phone" , $request->phone)->get();
            if(count($dataDriver) > 0){
                if($driver->account > $request->money){
                    // $job = $request->type === 'driver'? 'السائق' : 'العميل';
                    $message ="مرحبا سائق الجواب عملية تحويل رصيد الرمز ";
                    $code = $this->send_code($driver->phone, $message , $request->phone_id );
                    if($code !== false){
                        $dataDriver[0]->code = $code;
                        $dataDriver[0]->amount = $request->money;

                        $data = (object)[

                            'name'=>(string)$dataDriver[0]->name,
                            'code'=>(string)$dataDriver[0]->code,
                            'amount'=>(string)$dataDriver[0]->amount,
                            'phone'=>(string)$dataDriver[0]->phone
                        ];
                        return $this -> returnData( $data, 'driver data'); 
                    }else{
                        return $this->returnError('100003', "verification code has not sent ");
                    }   
                }else{
                    return $this->returnError('100011',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('100012',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");

            }
        }
        else if($request->type === 'rider')
        {
            $dataDriver = \App\Models\Rider::select(['id', 'name', 'phone'])
                                        ->where("phone" , $request->phone)->get();
            if(count($dataDriver) > 0){
                if($dataDriver->account > $request->money){
                    // $job = $request->type === 'driver'? 'السائق' : 'العميل';
                    $message ="مرحبا سائق الجواب عملية تحويل رصيد الرمز ";
                    $code = $this->send_code($driver->phone , $message , $request->phone_id );
                    if($code !== false){
                        $dataDriver[0]->code = $code;
                        $dataDriver[0]->amount = $request->money;
                        $data = (object)[
                            'name'=>(string)$dataDriver[0]->name,
                            'code'=>(string)$dataDriver[0]->code,
                            'amount'=>(string)$dataDriver[0]->amount,
                            'phone'=>(string)$dataDriver[0]->phone
                        ];
                        return $this -> returnData($data, 'rider data'); 
                    }else{
                        return $this->returnError('100003', "verification code has not sent ");
                    }   
                }else{
                    return $this->returnError('100011',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('100012',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");
            }
        }
        else{
            return $this->returnError('100012',"الرجاء التأكد من الجهة المحول لها  ");
        }
        
    }
}
