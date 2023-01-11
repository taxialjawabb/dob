<?php

namespace App\Http\Controllers\Api\Rider;
use App\Models\banner;
use App\Models\notes;
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
    

    public function rider_data(Request $request)
    {
        $riderData = Auth::guard('rider-api') -> user();
        if($riderData !== null){
        
            $riderData->api_token  = $request->header('auth-token');
            $verison = Version::all();
            $notes = notes::select(['id' ,'title_ar','title_en','subtitle_ar','subtitle_en'])->get()->last();
            $banner = banner::select(['id','title','image'])->get();
          
            $verison = Version::all();
            $user = (object)[
                'id'=>(string)$riderData->id,
                'name'=>$riderData->name,
                'phone'=>$riderData->phone,
                'account'=>(double)$riderData->account,
                'api_token'=>$riderData->api_token,
                'state'=>$riderData->state,
                'rider_rate'=>(string)$riderData->rider_rate,
                'rider_counter'=>(string)$riderData->rider_counter,
                'address'=>(string)$riderData->address,
                'birthDate'=>(string)$riderData->birth_date,
                'email'=>$riderData->email,
                'currentVersionAndroid' =>  $verison[0]->rider,
                'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                'currentVersionIos' =>  $verison[1]->rider,
                'updatedIos' =>  $verison[1]->rider_state==0?false:true
            ];

            $data = (object) [
                'user' => $user,
                'banners'=>$banner,
                'notes'=>$notes


            ];

            return $this -> returnData($data,'rider data');
        }
        else{
            return $this->returnError('100008', "rider not exist ");

        }
    }
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
                return $this->returnError('100006', 'هذه البيانات موجودة بالفعل');
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
                return $this->returnError('100004', 'some thing went wrongs');
            }else{
                $riderData = Auth::guard('rider-api') -> user();
                $riderData -> api_token = $token;
      
        
                $verison = Version::all();
                $data = (object)[
                    'id'=>(string)$riderData->id,
                    'name'=>$riderData->name,
                    'phone'=>$riderData->phone,
                    'account'=>(double)$riderData->account,
                    'api_token'=>$riderData->api_token,
                    'state'=>$riderData->state,
                    'rider_rate'=>(string)$riderData->driver_rate,
                    'rider_counter'=>(string)$riderData->driver_counter,
                    'address'=>(string)$riderData->address,
                    'birthDate'=>(string)$riderData->birth_date,
                    'email'=>$riderData->email,
                    'currentVersionAndroid' =>  $verison[0]->rider,
                    'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                    'currentVersionIos' =>  $verison[1]->rider,
                    'updatedIos' =>  $verison[1]->rider_state==0?false:true
                ];
               
                return $this -> returnData($data,'login successfuly');  
            }    
        }catch(\Exception $ex){
            return $this->returnError('100004', $ex->getMessage());

        }
    }

    public function check_phone(Request $request)
    {
        $request->validate([
            'phone'    => ['required', 'string', 'min:10', 'max:10'],
            'phone_id'    => ['required', 'string'],
        ]);
        $rider = Rider::where("phone",$request->phone)->get();
        if(count($rider) > 0 && $rider[0]->state === 'deleted'){
            return $this->returnError('100001', "phone number is deleted ");
        }
        if(count($rider) > 0 && $rider[0]->state === 'blocked'){
            return $this->returnError('100002', "phone number is blocked "); 
        }
        if(count($rider) > 0){
            $verison = Version::all();
            $data = (object)[
                
                'isRegistered' =>  true,
                'currentVersionAndroid' =>  $verison[0]->rider,
                'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                'currentVersionIos' =>  $verison[1]->rider,
                'updatedIos' =>  $verison[1]->rider_state==0?false:true
            ];
            return $this -> returnData($data,'true');  

        }
        else{
            $message ="مرحبا عميل الجواب الرمز  ";    
            $code = $this->send_code($request->phone, $message , $request->phone_id);
            if($code !== false){
                $verison = Version::all();
                $data = (object)[
                    'code' => (string)$code,
                    'isRegistered' =>  false,
                    'currentVersionAndroid' =>  $verison[0]->rider,
                    'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                    'currentVersionIos' =>  $verison[1]->rider,
                    'updatedIos' =>  $verison[1]->rider_state==0?false:true
                ];
                return $this -> returnData($data,'un registered');
            }else{
                return $this->returnError('100003', "verification code has not sent ");
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
                return $this->returnError('100004', 'some thing went wrongs');
            }else{
                $riderData = Auth::guard('rider-api') -> user();
                $riderData -> remember_token = $request->device_token;
                $riderData->update();
                $riderData -> api_token = $token;

                $verison = Version::all();
                $data = (object)[
                    'id'=>(string)$riderData->id,
                    'name'=>$riderData->name,
                    'phone'=>$riderData->phone,
                    'account'=>(double)$riderData->account,
                    'api_token'=>$riderData->api_token,
                    'state'=>$riderData->state,
                    'rider_rate'=>(string)$riderData->rider_rate,
                    'rider_counter'=>(string)$riderData->rider_counter,
                    'address'=>(string)$riderData->address,
                    'birthDate'=>(string)$riderData->birth_date,
                    'email'=>$riderData->email,
                    'currentVersionAndroid' =>  $verison[0]->rider,
                    'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                    'currentVersionIos' =>  $verison[1]->rider,
                    'updatedIos' =>  $verison[1]->rider_state==0?false:true
                ];
               
                return $this -> returnData($data,'login successfuly');  
            }    
        }catch(\Exception $ex){
            return $this->returnError('100004', $ex->getMessage());

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
                return  $this -> returnError('100000','some thing went wrongs');
            }
            // catch(\Exception $ex){
            //     return $this->returnError($ex->getCode(), $ex->getMessage());
            // }   
            return $this->returnSuccessMessage("Logout Successfully");
        }else{
            return $this->returnError('100000', 'some thing is wrongs');
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
                    $data = (object)[
                                'id'=>(string)$riderData->id,
                                'name'=>$riderData->name,
                                'phone'=>$riderData->phone,
                                'account'=>(double)$riderData->account,
                                'api_token'=>$riderData->api_token,
                                'state'=>$riderData->state,
                                'rider_rate'=>(string)$riderData->rider_rate,
                                'rider_counter'=>(string)$riderData->rider_counter,
                                'address'=>(string)$riderData->address,
                                'birthDate'=>(string)$riderData->birth_date,
                                'email'=>$riderData->email,
                                'currentVersionAndroid' =>  $verison[0]->rider,
                                'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                                'currentVersionIos' =>  $verison[1]->rider,
                                'updatedIos' =>  $verison[1]->rider_state==0?false:true
                            ];
           
                        return $this -> returnData($data,'update emial successfuly');
               
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('100000', "Email is't not update");
            }
        }
        return $this->returnError('100000', "Email is't not update");
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
                    $data = (object)[
                                'id'=>(string)$riderData->id,
                                'name'=>$riderData->name,
                                'phone'=>$riderData->phone,
                                'account'=>(double)$riderData->account,
                                'api_token'=>$riderData->api_token,
                                'state'=>$riderData->state,
                                'rider_rate'=>(string)$riderData->rider_rate,
                                'rider_counter'=>(string)$riderData->rider_counter,
                                'address'=>(string)$riderData->address,
                                'birthDate'=>(string)$riderData->birth_date,
                                'email'=>$riderData->email,
                                'currentVersionAndroid' =>  $verison[0]->rider,
                                'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                                'currentVersionIos' =>  $verison[1]->rider,
                                'updatedIos' =>  $verison[1]->rider_state==0?false:true
                            ];
           
                        return $this -> returnData($data,'update password successfuly');
               
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('100000', "Email is't not update");
            }
        }
        return $this->returnError('100000', "Email is't not update");   
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
                    return $this->returnError('100006', "Phone number already exist");
                }
                if($riderData){
                    $riderData -> phone = $request->phone;
                    $riderData->save();
                    $riderData -> api_token = $token;
                    $verison = Version::all();
                    $data = (object)[
                                'id'=>(string)$riderData->id,
                                'name'=>$riderData->name,
                                'phone'=>$riderData->phone,
                                'account'=>(double)$riderData->account,
                                'api_token'=>$riderData->api_token,
                                'state'=>$riderData->state,
                                'rider_rate'=>(string)$riderData->rider_rate,
                                'rider_counter'=>(string)$riderData->rider_counter,
                                'address'=>(string)$riderData->address,
                                'birthDate'=>(string)$riderData->birth_date,
                                'email'=>$riderData->email,
                                'currentVersionAndroid' =>  $verison[0]->rider,
                                'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                                'currentVersionIos' =>  $verison[1]->rider,
                                'updatedIos' =>  $verison[1]->rider_state==0?false:true
                            ];
           
                        return $this -> returnData($data,'update password successfuly');
               
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('100000', "Phone is't not update");     
            }
        }
        return $this->returnError('100000', "Phone is't not update");     
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
                        $data = (object)[
                                    'id'=>(string)$riderData->id,
                                    'name'=>$riderData->name,
                                    'phone'=>$riderData->phone,
                                    'account'=>(double)$riderData->account,
                                    'api_token'=>$riderData->api_token,
                                    'state'=>$riderData->state,
                                    'rider_rate'=>(string)$riderData->rider_rate,
                                    'rider_counter'=>(string)$riderData->rider_counter,
                                    'address'=>(string)$riderData->address,
                                    'birthDate'=>(string)$riderData->birth_date,
                                    'email'=>$riderData->email,
                                    'currentVersionAndroid' =>  $verison[0]->rider,
                                    'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                                    'currentVersionIos' =>  $verison[1]->rider,
                                    'updatedIos' =>  $verison[1]->rider_state==0?false:true
                                ];
               
                            return $this -> returnData($data,'update password successfuly');  
                    }
                    else{
                        return $this->returnError('100009', "Password is't not update");
                    }
                }else{
                    return $this->returnError('100008', "Password is't not update");
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('100000', "Password is't not update");
            }
        }
        return $this->returnError('100000', "Password is't not update");
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
                    $data = (object)[
                                'id'=>(string)$riderData->id,
                                'name'=>$riderData->name,
                                'phone'=>$riderData->phone,
                                'account'=>(double)$riderData->account,
                                'api_token'=>$riderData->api_token,
                                'state'=>$riderData->state,
                                'rider_rate'=>(string)$riderData->rider_rate,
                                'rider_counter'=>(string)$riderData->rider_counter,
                                'address'=>(string)$riderData->address,
                                'birthDate'=>(string)$riderData->birth_date,
                                'email'=>$riderData->email,
                                'currentVersionAndroid' =>  $verison[0]->rider,
                                'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                                'currentVersionIos' =>  $verison[1]->rider,
                                'updatedIos' =>  $verison[1]->rider_state==0?false:true
                            ];
           
                        return $this -> returnData($data,'update password successfuly');
               
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('100000', "Password is't not update");
            }
        }
        return $this->returnError('100000', "Password is't not update");
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
                    $data = (object)[
                                'id'=>(string)$riderData->id,
                                'name'=>$riderData->name,
                                'phone'=>$riderData->phone,
                                'account'=>(double)$riderData->account,
                                'api_token'=>$riderData->api_token,
                                'state'=>$riderData->state,
                                'rider_rate'=>(string)$riderData->rider_rate,
                                'rider_counter'=>(string)$riderData->rider_counter,
                                'address'=>(string)$riderData->address,
                                'birthDate'=>(string)$riderData->birth_date,
                                'email'=>$riderData->email,
                                'currentVersionAndroid' =>  $verison[0]->rider,
                                'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                                'currentVersionIos' =>  $verison[1]->rider,
                                'updatedIos' =>  $verison[1]->rider_state==0?false:true
                            ];
           
                        return $this -> returnData($data,'update password successfuly');
              
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('100000', "Password is't not update");
            }
        }
        return $this->returnError('100000', "Password is't not update");
    }

    public function send_message_reset(Request $request)
    {
        $request->validate([
            'phone'    => ['required', 'string'],
            'password' => ['required', 'string'],
           
        ]);
        $riders = Rider::where('phone', $request->phone)->get();
        if(count($riders) > 0 ){
            $riderData = $riders[0];
            $riderData -> password =  Hash::make($request->password);
            $riderData->save();
            $verison = Version::all();
            $data = (object)[
                        'id'=>(string)$riderData->id,
                        'name'=>$riderData->name,
                        'phone'=>$riderData->phone,
                        'account'=>(double)$riderData->account,
                        'api_token'=>$riderData->api_token,
                        'state'=>$riderData->state,
                        'rider_rate'=>(string)$riderData->rider_rate,
                        'rider_counter'=>(string)$riderData->rider_counter,
                        'address'=>(string)$riderData->address,
                        'birthDate'=>(string)$riderData->birth_date,
                        'email'=>$riderData->email,
                        'currentVersionAndroid' =>  $verison[0]->rider,
                        'updatedAndroid' =>  $verison[0]->rider_state==0?false:true,
                        'currentVersionIos' =>  $verison[1]->rider,
                        'updatedIos' =>  $verison[1]->rider_state==0?false:true
                    ];
   
                return $this -> returnData($data,'update password successfuly');    
            }  
        return $this->returnError('100008', "Password is't not update");
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
                return $this->returnError('100000', "Password is't not update");
            }
            $data = true;
            return $this->returnData($data,"delete account succesfully");
        }else{
            return $this->returnError('100000', "Password is't not update");
        }
        
    }    


}