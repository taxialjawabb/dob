<?php

namespace App\Http\Controllers\Api\Rider;
use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\Rider;
use Hash;
use Illuminate\Support\Facades\Http;
use App\Models\Version;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class RiderAuthController extends Controller
{
    use GeneralTrait;
    
    public function register(Request $request)
    {

        try{
            $request->validate([
                'name'     => ['required', 'max:255',  'string'],
                'password' => ['required', 'max:255', 'string', 'min:6'],
                'phone'    => ['required', 'string', 'min:10', 'max:14' ],
                'address'    => ['required', 'string', 'min:3', 'max:155' ],
                'device_token'    => ['required', 'string' ],
            ]);
            $rider = Rider::where('phone', $request->phone)->first();
            if($rider){
                return $this->returnError('E001', 'rider already exist');
            }
            $rider = new Rider();

            $rider->name = $request->name;
            $rider->password = Hash::make($request->password);
            $rider->phone = $request->phone;
            $rider->address = $request->address;
            $rider->remember_token = $request->device_token;
            $rider->save();
    
            $credentials = $request->only(['phone', 'password']);

            $token = Auth::guard('rider-api')->attempt($credentials);
            if(!$token){
                return $this->returnError('E001', 'some thing went wrongs');
            }else{
                $riderData = Auth::guard('rider-api') -> user();
                $riderData -> api_token = $token;
                $verison = Version::all();
                $riderData -> version = $verison[0]->rider;
                $riderData -> updating = $verison[0]->rider_state;
                $riderData -> iosVersion = $verison[1]->rider;
                $riderData -> iosUpdating = $verison[1]->rider_state;    
                return $this -> returnData('rider' , $riderData,'register successfuly');
            }    
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());

        }
    }

    public function chech_phone(Request $request)
    {
        $request->validate([
            'phone'    => ['required', 'string', 'min:10', 'max:10'],
            'phone_id'    => ['required', 'string'],
        ]);
        $rider = Rider::where("phone",$request->phone)->get();
        if(count($rider) > 0 && $rider[0]->state === 'deleted'){
            return $this->returnError('E001', "phone number is deleted ");
        }
        if(count($rider) > 0 && $rider[0]->state === 'blocked'){
            return $this->returnError('E002', "phone number is blocked ");
        }
        if(count($rider) > 0){
            $verison = Version::all();
            $data = (object)[
                'version' => $verison[0]->rider,
                'updating' => $verison[0]->rider_state,
                'iosVersion' => $verison[1]->rider,
                'iosUpdating' => $verison[1]->rider_state
            ];
            return $this -> returnData('version' , $data,'true');

        }
        else{
            $message ="مرحبا عميل الجواب الرمز  ";    
            $code = $this->send_code($request->phone, $message , $request->phone_id);
            if($code !== false){
                $verison = Version::all();
                $data = (object)[
                    'code' => $code,
                    'version' => $verison[0]->rider,
                    'updating' => $verison[0]->rider_state,
                    'iosVersion' => $verison[1]->rider,
                    'iosUpdating' => $verison[1]->rider_state
                ];
                return $this -> returnData('code' , $data, 'false');
            }else{
                return $this->returnError('', "verification code has not sent ");
            }
        }
    }

    public function login(Request $request)
    {
        try{
            $request->validate([
                'phone'    => ['required'],
                'password' => ['required'],
                'device_token' => ['required', 'string'],
            ]);
            $credentials = $request->only(['phone', 'password']);
            $token = Auth::guard('rider-api')->attempt($credentials);
            if(!$token){
                return $this->returnError('E001', 'some thing went wrongs');
            }else{
                $riderData = Auth::guard('rider-api') -> user();
                $riderData -> remember_token = $request->device_token;
                $riderData->update();
                $riderData -> api_token = $token;
                $verison = Version::all();
                $riderData -> version = $verison[0]->rider;
                $riderData -> updating = $verison[0]->rider_state;
                $riderData -> iosVersion = $verison[1]->rider;
                $riderData -> iosUpdating = $verison[1]->rider_state;    
                return $this -> returnData('rider' , $riderData,'login successfuly');
            }    
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());

        }
        
    }

    public function logout(Request $request)
    {
        $token = $request->header('auth-token');
        if($token){
            try {
                $riderData = Auth::guard('rider-api') -> user();
                $riderData -> remember_token = '';
                $riderData->update();

                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('','some thing went wrongs');
            }
            // catch(\Exception $ex){
            //     return $this->returnError($ex->getCode(), $ex->getMessage());
            // }   
            return $this->returnSuccessMessage("Logout Successfully");
        }else{
            return $this->returnError('', 'some thing is wrongs');
        }
        
    }    

    public function email_update(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
        ]);
        $token = $request->header('auth-token');
        if($token){
            try{
                $riderData = Auth::guard('rider-api') -> user();
                if($riderData){
                    $riderData -> email = $request->email;
                    $riderData->save();
                    $riderData -> api_token = $token;
                    $verison = Version::all();
                    $riderData -> version = $verison[0]->rider;
                    $riderData -> updating = $verison[0]->rider_state;
                    $riderData -> iosVersion = $verison[1]->rider;
                    $riderData -> iosUpdating = $verison[1]->rider_state;        
                    return $this -> returnData('rider' , $riderData,'Email updated successfuly');
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Email is't not update");
            }
        }
        return $this->returnError('', "Email is't not update");
    }
    public function name_update(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string'],
        ]);
        $token = $request->header('auth-token');
        if($token){
            try{
                $riderData = Auth::guard('rider-api') -> user();
                if($riderData){
                    $riderData -> name = $request->name;
                    $riderData->save();
                    $riderData -> api_token = $token;
                    $verison = Version::all();
                    $riderData -> version = $verison[0]->rider;
                    $riderData -> updating = $verison[0]->rider_state;
                    $riderData -> iosVersion = $verison[1]->rider;
                    $riderData -> iosUpdating = $verison[1]->rider_state;        
                    return $this -> returnData('rider' , $riderData,'Name updated successfuly');
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Name is't not update");
            }
        }
        return $this->returnError('', "Name is't not update");     
    }
    public function phone_update(Request $request)
    {
        $request->validate([
            'phone'    => ['required', 'string'],
        ]);
        $token = $request->header('auth-token');
        if($token){
            try{
                $riderData = Auth::guard('rider-api') -> user();
                $rider = Rider::where('phone', $request->phone)->get();
                if(count($rider)){
                    return $this->returnError('', "Phone number already exist");
                }
                if($riderData){
                    $riderData -> phone = $request->phone;
                    $riderData->save();
                    $riderData -> api_token = $token;
                    $verison = Version::all();
                    $riderData -> version = $verison[0]->rider;
                    $riderData -> updating = $verison[0]->rider_state;
                    $riderData -> iosVersion = $verison[1]->rider;
                    $riderData -> iosUpdating = $verison[1]->rider_state;        
                    return $this -> returnData('rider' , $riderData,'Phone updated successfuly');
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Phone is't not update");
            }
        }
        return $this->returnError('', "Phone is't not update");     
    }
    public function password_update(Request $request)
    {
        $request->validate([
            'new_password'    => ['required', 'string'],
            'old_password'    => ['required', 'string'],
        ]);
        $token = $request->header('auth-token');
        if($token){
            try{
                $riderData = Auth::guard('rider-api') -> user();
                if($riderData){
                    if( Hash::check( $request->old_password, $riderData->password)){
                        
                        $riderData -> password =  Hash::make($request->new_password);
                        $riderData->save();
                        $riderData -> api_token = $token;
                        $verison = Version::all();
                        $riderData -> version = $verison[0]->rider;
                        $riderData -> updating = $verison[0]->rider_state;
                        $riderData -> iosVersion = $verison[1]->rider;
                        $riderData -> iosUpdating = $verison[1]->rider_state;            
                        return $this -> returnData('rider' , $riderData,'Password updated successfuly');
                    }
                    else{
                        return $this->returnError('', "Password is't not update");
                    }
                }else{
                    return $this->returnError('', "Password is't not update");
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Password is't not update");
            }
        }
        return $this->returnError('', "Password is't not update");     
    }

    

    public function gender_update(Request $request)
    {
        $request->validate([
            'gender'    => 'required|string|in:male,female',
        ]);
        $token = $request->header('auth-token');
        if($token){
            try{
                $riderData = Auth::guard('rider-api') -> user();
                if($riderData){
                    $riderData -> gender = $request->gender;
                    $riderData->save();
                    $riderData -> api_token = $token;
                    $verison = Version::all();
                    $riderData -> version = $verison[0]->rider;
                    $riderData -> updating = $verison[0]->rider_state;
                    $riderData -> iosVersion = $verison[1]->rider;
                    $riderData -> iosUpdating = $verison[1]->rider_state;        
                    return $this -> returnData('rider' , $riderData,'Gender updated successfuly');
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Gender is't not update");
            }
        }
        return $this->returnError('', "Gender is't not update");     
    }


    public function birth_date_update(Request $request)
    {
        $request->validate([
            'birth_date'    => 'required|string',
        ]);
        $token = $request->header('auth-token');
        if($token){
            try{
                $riderData = Auth::guard('rider-api') -> user();
                if($riderData){
                    $riderData -> birth_date = $request->birth_date;
                    $riderData->save();
                    $riderData -> api_token = $token;
                    $verison = Version::all();
                    $riderData -> version = $verison[0]->rider;
                    $riderData -> updating = $verison[0]->rider_state;
                    $riderData -> iosVersion = $verison[1]->rider;
                    $riderData -> iosUpdating = $verison[1]->rider_state;        
                    return $this -> returnData('rider' , $riderData,'Birth date updated successfuly');
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Birth date is't not update");
            }
        }
        return $this->returnError('', "Birth date is't not update");     
    }

    public function send_message_reset(Request $request)
    {
        $request->validate([
            'phone'    => ['required', 'string'],
            'new_password' => ['required', 'string'],
            'device_token' => ['required', 'string'],
        ]);
        $riders = Rider::where('phone', $request->phone)->get();
        if(count($riders) > 0 ){
            $rider = $riders[0];
            $rider -> password =  Hash::make($request->new_password);
            $rider->remember_token = $request->device_token;
            $rider->save();
            $token = Auth::guard('rider-api')->attempt(['phone' => $rider->phone, 'password' =>  $request->new_password]);
            if(!$token){
                return $this->returnError('E001', 'some thing went wrongs');
            }else{
                $rider->api_token = $token;
                $verison = Version::all();
                $rider -> version = $verison[0]->rider;
                $rider -> updating = $verison[0]->rider_state;
                $rider -> iosVersion = $verison[1]->rider;
                $rider -> iosUpdating = $verison[1]->rider_state;    
                return $this -> returnData('rider' , $rider,'reset password successfuly');    
            }  
        }
    }

    public function rider_update(Request $request)
    {
        try{
        
            $token = $request->header('auth-token');
            $riderData = Auth::guard('rider-api') -> user();
            if($riderData !== null && $token !== null)
            {
                $riderData->api_token = $token;
                $verison = Version::all();
                $riderData -> version = $verison[0]->rider;
                $riderData -> updating = $verison[0]->rider_state;
                $riderData -> iosVersion = $verison[1]->rider;
                $riderData -> iosUpdating = $verison[1]->rider_state;    
                return $this -> returnData('rider' , $riderData ,'rider data' );                 
            }    
            else{
                return $this->returnError('E001', 'some thing went wrongs');
            }
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());

        }
        
    }

    
    public function block_account(Request $request)
    {
        $token = $request->header('auth-token');
        if($token){
            try {
                $riderData = Auth::guard('rider-api') -> user();
                $riderData -> state = 'deleted';
                $riderData -> remember_token = '';
                $riderData->update();

                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('','some thing went wrongs');
            }
            // catch(\Exception $ex){
            //     return $this->returnError($ex->getCode(), $ex->getMessage());
            // }   
            return $this->returnSuccessMessage("delete account succesfully");
        }else{
            return $this->returnError('', 'some thing is wrongs');
        }
        
    }    
}

