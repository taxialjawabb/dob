<?php

namespace App\Http\Controllers\Api\Messages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Traits\GeneralTrait;
use App\Models\Rider;
use App\Models\Driver;

class MessagesController extends Controller
{
    use GeneralTrait;

    public function send_message(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14',
            'phone_id'    => 'required|string',

        ]);
        $rider = Rider::Where('phone', $request->phone)->get();
        if(count($rider) > 0){
            return $this->returnError('E001', 'phone number is already exist');
        }
        else{
            $message ="مرحبا عميل الجواب الرمز ";
            $code = $this->send_code($request->phone, $message , $request->phone_id);
            if($code !== false){
                return $this->returnSuccessMessage($code);
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        }
    }
    public function send_message_update(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14',
            'phone_id'    => 'required|string',
        ]);
            $message ="مرحبا عميل الجواب الرمز ";
            $code = $this->send_code($request->phone, $message , $request->phone_id);
            if($code !== false){
                return $this->returnSuccessMessage($code);
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        
    }

    public function send_message_reset(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14',
            'phone_id'    => 'required|string',
        ]);
        $rider = Rider::Where('phone', $request->phone)->get();
        if(count($rider) === 0){
            return $this->returnError('E002', 'phone number is not exist');
        }
        else if(count($rider) > 0 && $rider[0]->state === 'deleted'){
            return $this->returnError('E001', 'phone number is deleted');
        }
        else if(count($rider) > 0 && $rider[0]->state === 'blocked'){
            return $this->returnError('E003', 'phone number is blocked');
        }
        else{
            $message ="مرحبا عميل الجواب تغيير كلمة السرى الرمز ";
            $code = $this->send_code($request->phone, $message , $request->phone_id);
            if($code !== false){
                $verison = \App\Models\Version::all();
                $data = (object)[
                    'code' => $code,
                    'version' => $verison[0]->rider,
                    'updating' => $verison[0]->rider_state,
                    'iosVersion' => $verison[1]->rider,
                    'iosUpdating' => $verison[1]->rider_state
                ];
                return $this->returnData('code' , $data ,$rider[0]->state);
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        }
    }

    public function send_message_driver(Request $request)
    {
        $request->validate([
            'type_verification'=> 'required|string',
            'phone'    => 'required|string|min:10|max:14',
            'phone_id'    => 'required|string',
        ]);

        if($request->type_verification=='hasAccount')
        {

            $driver = Driver::Where('phone', $request->phone)->get();
            if(count($driver) === 0){
                return $this->returnError('100001', 'phone number is not exist');
            }
            else if(count($driver) > 0 && $driver[0]->state === 'deleted'){
                return $this->returnError('100002', 'phone number is not exist');
            }
            else
            {
    
                $message ="مرحبا سائق الجواب الرمز ";
                $code = $this->send_code($request->phone, $message , $request->phone_id);
                if($code !== false){
                    $data = (object)[
                        'code'=>(string)$code
                    ];
                    return $this->returnSuccessMessage($data);
                }else{
                    return $this->returnError('100003', "verification code has not sent ");
                }
            }
        }
        else
        {

            $message ="مرحبا سائق الجواب الرمز ";
            $code = $this->send_code($request->phone, $message , $request->phone_id);
            if($code !== false){
                $data = (object)[
                    'code'=>(string)$code
                ];
                return $this->returnSuccessMessage($data);
            }else{
                return $this->returnError('100003', "verification code has not sent ");
            }
        }
       
    }
    public function send_message_driver_reset(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14',
            'phone_id'    => 'required|string',
        ]);
        $driver = Driver::Where('phone', $request->phone)->get();

        if(count($driver) === 0){
            return $this->returnError('E002', 'phone number is not exist');
        }
        else if(count($driver) > 0 && $driver[0]->state === 'deleted'){
            return $this->returnError('E001', 'phone number is deleted');
        }
        else if(count($driver) > 0 && $driver[0]->state === 'blocked'){
            return $this->returnError('E003', 'phone number is blocked');
        }
        else{
            $message ="مرحبا سائق الجواب تغيير كلمة المرور الرمز ";
            $code = -1;
            if($driver[0]->state === 'active' || $driver[0]->state === 'waiting'){
                $code = $this->send_code($request->phone, $message , $request->phone_id);
            }
            if($code !== false){
                $verison = \App\Models\Version::all();
                $data = (object)[
                    'code' => $code,
                    'version' =>  $verison[0]->driver,
                    'updating' =>  $verison[0]->driver_state,
                    'iosVersion' =>  $verison[1]->driver,
                    'iosUpdating' =>  $verison[1]->driver_state
                ];
                return $this->returnData('code' , $data ,$driver[0]->state);
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        }
    }

    public function send_message_driver_update(Request $request)
    {
        $request->validate([
            'phone'    => 'required|string|min:10|max:14',
            'phone_id'    => 'required|string',

        ]);
            $message ="مرحبا سائق الجواب الرمز ";
            $code = $this->send_code($request->phone, $message , $request->phone_id);
            if($code !== false){
                return $this->returnSuccessMessage($code);
            }else{
                return $this->returnError('100003', "verification code has not sent ");
            }
        
    }
}
