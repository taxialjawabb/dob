<?php

namespace App\Http\Controllers\Admin\Groups\SharedGroups\contract;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ContractConfirmController extends Controller
{

    use GeneralTrait;
    public function send_code_driver(Request $request)
    {
        $request->validate([
        'id'=>'required|string',
        'plate_number' => 'required|string',
        'contract_number' => 'required|string',
        'start_contract' => 'required|string',
        'end_contract' => 'required|string',
        ]);
        $driver = \App\Models\Driver::select(['id','name', 'phone'])->find($request->id);
        if($driver !== null){
            $code = rand(1000,9999);
             return $this->returnData('code', '1111');
            $now =  Carbon::now();
            $token = env('SMS_TOKEN', '');
            $phone = '966'.substr($driver->phone, 1);
            $message = "تم اصدار عقد تأجير برقم ".$request->contract_number." من ".$request->start_contract." الى ".$request->end_contract." رقم اللوحة { ".$request->plate_number." } للسائق { ".$driver->name." } للموافقة على العقد يرجى تزويد الموظف بالرقم ( ".$code." )" ;
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $token
            ])->post('https://api.taqnyat.sa/v1/messages', [
                "recipients" =>  [
                    $phone
                ],
                "body" => $message,
                "sender" => "TaxiAljawab",
                "scheduledDatetime" =>  $now
            ]);
            $resp = json_decode($response);

            if($resp->statusCode === 201){
                return $this->returnData('code', $code);
            }
            else{
                return $this->returnError('E002', 'خطاء فى ارسال الرسالة');
            }
        }
        else{
            return $this->returnError('E001', 'خطاء فى بيانات السائق');
        }
    }

    public function send_code_user(Request $request)
    {
        $request->validate([
        'contract_number' => 'required|string',
        ]);
        $user = Auth::guard('admin')->user();
        if($user !== null){
            $code = rand(1000,9999);
           return $this->returnData('code', '1111');
            $now =  Carbon::now();
            $token = env('SMS_TOKEN', '');
            $phone = '966'.substr($user->phone, 1);
            $message = "عزيزي الموظف لإتمام إنشاء العقد رقم ".$request->contract_number." يرجى إدخال الرمز ( ".$code." ) علماً أن ادخال الرمز المرسل على جوالك هو إقرار منك على أن جميع البيانات المسجلة في العقد صحيحه وأنه تم شرح وتوضيح كامل بنود العقد للسائق وستتحمل كامل المسؤولية إذا أتضح خلاف ذلك.";
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $token
            ])->post('https://api.taqnyat.sa/v1/messages', [
                "recipients" =>  [
                    $phone
                ],
                "body" => $message,
                "sender" => "TaxiAljawab",
                "scheduledDatetime" =>  $now
            ]);
            $resp = json_decode($response);

            if($resp->statusCode === 201){
                return $this->returnData('code', $code);
            }
            else{
                return $this->returnError('E002', 'خطاء فى ارسال الرسالة');
            }
        }
        else{
            return $this->returnError('E001', 'خطاء فى بيانات السائق');
        }
    }
}
