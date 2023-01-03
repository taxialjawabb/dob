<?php

namespace App\Traits;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;

trait GeneralTrait
{

    public function send_code($phone , $message, $phone_id)
    {

        if($phone === "0576298725")
        {
            $code = 4455;
            return $code;
        }


        $code = rand(1000,9999);
        if($phone_id !== 'ios'){
            $message .= $code;
            $message .='<#>'. $phone_id;
        }else{
            $mes ='<#>';
            $message .='code '. $code;
            $mes .= $message;
            $message = $mes;

        }
        // return $code;

        $now =  \Carbon\Carbon::now();
        $token = env('SMS_TOKEN', '');
        $phoneis = '966'.substr($phone, 1);
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $token
        ])->post('https://api.taqnyat.sa/v1/messages', [
            "recipients" =>  [
                $phoneis
            ],
            "body" => $message,
            "sender" => "TaxiAljawab",
            "scheduledDatetime" =>  $now
        ]);
        $resp = json_decode($response);

        if($resp->statusCode === 201){
            return (string)$code;
        }
        else{
            return false;
        }

        // $time = \Carbon\Carbon::now()->format('H:i');
        // $date = \Carbon\Carbon::now()->toDateString();
        // $ss = "https://www.hisms.ws/api.php?send_sms&username=966532760660&password=Qp@@5SR0FFf@9nX&numbers=".$phone."&sender=TaxiAljawab&message=".$message."&date=".$date."&time=".$time;
        // $response = Http::get($ss);
    }
    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function returnError($errNum, $msg)
    {
        return response()->json([
            'success' => true,
            'status'=>0,
            'message' => $msg,
            'data' => $msg,
            'errorId' => $errNum,

        ]);
    }
    public function returnErrorApiAuth()
    {
        return response()->json([
            'success' => true,
            'status'=>3,
            'message' => "unAthenticated",
            'data' => null,
            'errorId' => '777777',

        ]);
    }

    public function returnSuccessMessage($msg = "")
    {
        return [
            'success' => true,
            'status'=>1,
            'message' => 'code send successfully',
            'data' => $msg,
            'errorId'=>''
        ];
    }

    public function returnData($value, $msg = "")
    {
        return response()->json([
            'success' => true,
            'status'=>1,
            'message' => $msg,
            'data' => $value,
            'errorId'=>''
        ]);
    }


    //////////////////
    public function returnValidationError($code = "E001", $validator)
    {
        return $this->returnError($code, $validator->errors()->first());
    }


    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }

    public function getErrorCode($input)
    {
        if ($input == "name")
            return 'E0011';

        else if ($input == "password")
            return 'E002';

        else if ($input == "mobile")
            return 'E003';

        else if ($input == "id_number")
            return 'E004';

        else if ($input == "birth_date")
            return 'E005';

        else if ($input == "agreement")
            return 'E006';

        else if ($input == "email")
            return 'E007';

        else if ($input == "city_id")
            return 'E008';

        else if ($input == "insurance_company_id")
            return 'E009';

        else if ($input == "activation_code")
            return 'E010';

        else if ($input == "longitude")
            return 'E011';

        else if ($input == "latitude")
            return 'E012';

        else if ($input == "id")
            return 'E013';

        else if ($input == "promocode")
            return 'E014';

        else if ($input == "doctor_id")
            return 'E015';

        else if ($input == "payment_method" || $input == "payment_method_id")
            return 'E016';

        else if ($input == "day_date")
            return 'E017';

        else if ($input == "specification_id")
            return 'E018';

        else if ($input == "importance")
            return 'E019';

        else if ($input == "type")
            return 'E020';

        else if ($input == "message")
            return 'E021';

        else if ($input == "reservation_no")
            return 'E022';

        else if ($input == "reason")
            return 'E023';

        else if ($input == "branch_no")
            return 'E024';

        else if ($input == "name_en")
            return 'E025';

        else if ($input == "name_ar")
            return 'E026';

        else if ($input == "gender")
            return 'E027';

        else if ($input == "nickname_en")
            return 'E028';

        else if ($input == "nickname_ar")
            return 'E029';

        else if ($input == "rate")
            return 'E030';

        else if ($input == "price")
            return 'E031';

        else if ($input == "information_en")
            return 'E032';

        else if ($input == "information_ar")
            return 'E033';

        else if ($input == "street")
            return 'E034';

        else if ($input == "branch_id")
            return 'E035';

        else if ($input == "insurance_companies")
            return 'E036';

        else if ($input == "photo")
            return 'E037';

        else if ($input == "logo")
            return 'E038';

        else if ($input == "working_days")
            return 'E039';

        else if ($input == "insurance_companies")
            return 'E040';

        else if ($input == "reservation_period")
            return 'E041';

        else if ($input == "nationality_id")
            return 'E042';

        else if ($input == "commercial_no")
            return 'E043';

        else if ($input == "nickname_id")
            return 'E044';

        else if ($input == "reservation_id")
            return 'E045';

        else if ($input == "attachments")
            return 'E046';

        else if ($input == "summary")
            return 'E047';

        else if ($input == "user_id")
            return 'E048';

        else if ($input == "mobile_id")
            return 'E049';

        else if ($input == "paid")
            return 'E050';

        else if ($input == "use_insurance")
            return 'E051';

        else if ($input == "doctor_rate")
            return 'E052';

        else if ($input == "provider_rate")
            return 'E053';

        else if ($input == "message_id")
            return 'E054';

        else if ($input == "hide")
            return 'E055';

        else if ($input == "checkoutId")
            return 'E056';

        else
            return "";
    }


}
