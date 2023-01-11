<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use App\Models\banner;
use DB;
use Illuminate\Http\Request;

use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;
use App\Models\Driver;
use App\Models\Version;
use Hash;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Driver\DriverDocuments;
use App\Models\notes;

class DriverAuthController extends Controller
{   
    use GeneralTrait;
    public function login(Request $request)
    {
        try{
            $request->validate([
                'phone'    => ['required'],
                'password' => ['required'],
                'device_token' => ['required','string'],
            ]);

            $driver = Driver::where("phone",$request->phone)->get();
            if(count($driver) > 0){
                if($driver[0]->password == "0"){
                    $driver[0]->password = Hash::make($request->password);
                    $driver[0]->save();
                }
            }
            $credentials = $request->only(['phone', 'password']); 
            
            $token = Auth::guard('driver-api')->attempt($credentials);

            if(!$token)
            {
                return $this->returnError('100004', 'some thing went wrongs');
            }
            else{
                $driverData = Auth::guard('driver-api') -> user();
                $driverData->remember_token = $request->device_token;
                $driverData->available = 0;
                $driverData->update();
                $driverData->api_token = $token;
                $verison = Version::all();
                $driverData -> version = $verison[0]->driver;
                $driverData -> updating = $verison[0]->driver_state;
                $driverData -> iosVersion = $verison[1]->driver;
                $driverData -> iosUpdating = $verison[1]->driver_state;
     
        
                $verison = Version::all();
                $data = (object)[
                    'id'=>(string)$driverData->id,
                    'name'=>$driverData->name,
                    'phone'=>$driverData->phone,
                    'account'=>(double)$driverData->account,
                    'api_token'=>$driverData->api_token,
                    'current_vechile'=>(string)$driverData->current_vechile,
                    'current_loc_latitude'=>$driverData->current_loc_latitude,
                    'current_loc_longtitude'=>$driverData->current_loc_longtitude,
                    'current_loc_name'=>$driverData->current_loc_name,
                    'persnol_photo'=>$driverData->persnol_photo,
                    'state'=>$driverData->state,
                    'driverRate'=>(string)$driverData->driver_rate,
                    'driverCounter'=>(string)$driverData->driver_counter,
                    'vechileRate'=>(string)$driverData->vechile_rate,
                    'vechileCounter'=>(string)$driverData->vechile_counter,
                    'timeRate'=>(string)$driverData->time_rate,
                    'timeCounter'=>(string)$driverData->time_counter,
                    'idCopyNo'=>(string)$driverData->id_copy_no,
                    'idExpirationDate'=>$driverData->id_expiration_date,
                    'licenseType'=>$driverData->license_type,
                    'licenseExpirationDate'=>$driverData->license_expiration_date,
                    'birthDate'=>(string)$driverData->birth_date,
                    'startWorkingDate'=>$driverData->start_working_date,
                    'contractEndDate'=>$driverData->contract_end_date,
                    'finalClearanceDate'=>$driverData->final_clearance_date,
                    'email'=>$driverData->email,
                    'ssd'=>$driverData->ssd,
                    'currentVersionAndroid' =>  $verison[0]->driver,
                    'updatedAndroid' =>  $verison[0]->driver_state==0?false:true,
                    'currentVersionIos' =>  $verison[1]->driver,
                    'updatedIos' =>  $verison[1]->driver_state==0?false:true
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
        $driver = Driver::where("phone",$request->phone)->get();
        if(count($driver) > 0 && $driver[0]->state === 'deleted'){
            return $this->returnError('100001', "phone number is deleted ");
            
        }
        if(count($driver) > 0 && $driver[0]->state === 'blocked'){
            return $this->returnError('100002', "phone number is blocked ");            
        }
        if(count($driver) > 0){
            $verison = Version::all();
            $data = (object)[
                
                'isRegistered' =>  true,
                'currentVersionAndroid' =>  $verison[0]->driver,
                'updatedAndroid' =>  $verison[0]->driver_state==0?false:true,
                'currentVersionIos' =>  $verison[1]->driver,
                'updatedIos' =>  $verison[1]->driver_state==0?false:true
            ];
            return $this -> returnData($data,'true');    
        }
        else{
            $message ="مرحبا سائق الجواب الرمز ";
            // return $this->send_code($request->phone, $message);
            $code = $this->send_code($request->phone, $message , $request->phone_id);
            
            if($code !== false){
                $verison = Version::all();
                $data = (object)[
                    'code' => (string)$code,
                    'isRegistered' =>  false,
                    'currentVersionAndroid' =>  $verison[0]->driver,
                    'updatedAndroid' =>  $verison[0]->driver_state==0?false:true,
                    'currentVersionIos' =>  $verison[1]->driver,
                    'updatedIos' =>  $verison[1]->driver_state==0?false:true
                ];
                return $this -> returnData($data,'un registered');
            }else{
                return $this->returnError('100003', "verification code has not sent ");
            }
        }
    }

    public function driver_data(Request $request)
    {
        $driverData = Auth::guard('driver-api') -> user();
        if($driverData !== null){
            $driverData->available = 1;
            $driverData->save();
            $driverData->api_token  = $request->header('auth-token');
            $verison = Version::all();
           $notes = notes::select(['id' ,'title_ar','title_en','subtitle_ar','subtitle_en'])->get()->last();
            $banner = banner::select(['id','title','image'])->get();
          
            $verison = Version::all();
            $user = (object)[
                'id'=>(string)$driverData->id,
                'name'=>$driverData->name,
                'phone'=>$driverData->phone,
                'account'=>(double)$driverData->account,
                'api_token'=>$driverData->api_token,
                'current_vechile'=>(string)$driverData->current_vechile,
                'current_loc_latitude'=>$driverData->current_loc_latitude,
                'current_loc_longtitude'=>$driverData->current_loc_longtitude,
                'current_loc_name'=>$driverData->current_loc_name,
                'persnol_photo'=>$driverData->persnol_photo,
                'state'=>$driverData->state,
                'driverRate'=>(string)$driverData->driver_rate,
                'driverCounter'=>(string)$driverData->driver_counter,
                'vechileRate'=>(string)$driverData->vechile_rate,
                'vechileCounter'=>(string)$driverData->vechile_counter,
                'timeRate'=>(string)$driverData->time_rate,
                'timeCounter'=>(string)$driverData->time_counter,
                'idCopyNo'=>(string)$driverData->id_copy_no,
                'idExpirationDate'=>$driverData->id_expiration_date,
                'licenseType'=>$driverData->license_type,
                'licenseExpirationDate'=>$driverData->license_expiration_date,
                'birthDate'=>(string)$driverData->birth_date,
                'startWorkingDate'=>$driverData->start_working_date,
                'contractEndDate'=>$driverData->contract_end_date,
                'finalClearanceDate'=>$driverData->final_clearance_date,
                'email'=>$driverData->email,
                'ssd'=>$driverData->ssd,
                'currentVersionAndroid' =>  $verison[0]->driver,
                'updatedAndroid' =>  $verison[0]->driver_state==0?false:true,
                'currentVersionIos' =>  $verison[1]->driver,
                'updatedIos' =>  $verison[1]->driver_state==0?false:true
            ];

            $data = (object) [
                'user' => $user,
                'banners'=>$banner,
                'notes'=>$notes


            ];

            return $this -> returnData($data,'driver data');
        }
        else{
            return $this->returnError('100008', "driver not exist ");

        }
    }
    public function logout(Request $request)
    {
        $token = $request->header('auth-token');
        if($token){
            try {
                $driverData = Auth::guard('driver-api') -> user();
                $driverData -> remember_token = '';
                $driverData->update();

                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('100000','some thing went wrongs');
            }
              
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
                $driverData = Auth::guard('driver-api') -> user();
                if($driverData){
                    $driverData -> email = $request->email;
                    $driverData->save();
                    $driverData->api_token = $token;
                    $verison = Version::all();
                    $data = (object)[
                        'id'=>(string)$driverData->id,
                        'name'=>$driverData->name,
                        'phone'=>$driverData->phone,
                        'account'=>(double)$driverData->account,
                        'api_token'=>$driverData->api_token,
                        'current_vechile'=>(string)$driverData->current_vechile,
                        'current_loc_latitude'=>$driverData->current_loc_latitude,
                        'current_loc_longtitude'=>$driverData->current_loc_longtitude,
                        'current_loc_name'=>$driverData->current_loc_name,
                        'persnol_photo'=>$driverData->persnol_photo,
                        'state'=>$driverData->state,
                        'driverRate'=>(string)$driverData->driver_rate,
                        'driverCounter'=>(string)$driverData->driver_counter,
                        'vechileRate'=>(string)$driverData->vechile_rate,
                        'vechileCounter'=>(string)$driverData->vechile_counter,
                        'timeRate'=>(string)$driverData->time_rate,
                        'timeCounter'=>(string)$driverData->time_counter,
                        'idCopyNo'=>(string)$driverData->id_copy_no,
                        'idExpirationDate'=>$driverData->id_expiration_date,
                        'licenseType'=>$driverData->license_type,
                        'licenseExpirationDate'=>$driverData->license_expiration_date,
                        'birthDate'=>(string)$driverData->birth_date,
                        'startWorkingDate'=>$driverData->start_working_date,
                        'contractEndDate'=>$driverData->contract_end_date,
                        'finalClearanceDate'=>$driverData->final_clearance_date,
                        'email'=>$driverData->email,
                        'ssd'=>$driverData->ssd,
                        'currentVersionAndroid' =>  $verison[0]->driver,
                        'updatedAndroid' =>  $verison[0]->driver_state==0?false:true,
                        'currentVersionIos' =>  $verison[1]->driver,
                        'updatedIos' =>  $verison[1]->driver_state==0?false:true
                    ]; 

                    return $this -> returnData($data,'Email updated successfuly');
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
                $driverData = Auth::guard('driver-api') -> user();
                if($driverData){
                    $driverData -> name = $request->name;
                    $driverData->save();
                    $driverData->api_token = $token;
                    $verison = Version::all();
                    $driverData -> version = $verison[0]->driver;
                    $driverData -> updating = $verison[0]->driver_state;
                    $driverData -> iosVersion = $verison[1]->driver;
                    $driverData -> iosUpdating = $verison[1]->driver_state;    
                    return $this -> returnData('driver' , $driverData,'Name updated successfuly');
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
                $driverData = Auth::guard('driver-api') -> user();
                $driver = Driver::where('phone', $request->phone)->get();
                if(count($driver)){
                    return $this->returnError('100006', "Phone number already exist");
                }
                if($driverData !== null){
                    $driverData->phone = $request->phone;
                    $driverData->save();
                    $driverData->api_token = $token;
                    $verison = Version::all();
                    $data = (object)[
                        'id'=>(string)$driverData->id,
                        'name'=>$driverData->name,
                        'phone'=>$driverData->phone,
                        'account'=>(double)$driverData->account,
                        'api_token'=>$driverData->api_token,
                        'current_vechile'=>(string)$driverData->current_vechile,
                        'current_loc_latitude'=>$driverData->current_loc_latitude,
                        'current_loc_longtitude'=>$driverData->current_loc_longtitude,
                        'current_loc_name'=>$driverData->current_loc_name,
                        'persnol_photo'=>$driverData->persnol_photo,
                        'state'=>$driverData->state,
                        'driverRate'=>(string)$driverData->driver_rate,
                        'driverCounter'=>(string)$driverData->driver_counter,
                        'vechileRate'=>(string)$driverData->vechile_rate,
                        'vechileCounter'=>(string)$driverData->vechile_counter,
                        'timeRate'=>(string)$driverData->time_rate,
                        'timeCounter'=>(string)$driverData->time_counter,
                        'idCopyNo'=>(string)$driverData->id_copy_no,
                        'idExpirationDate'=>$driverData->id_expiration_date,
                        'licenseType'=>$driverData->license_type,
                        'licenseExpirationDate'=>$driverData->license_expiration_date,
                        'birthDate'=>(string)$driverData->birth_date,
                        'startWorkingDate'=>$driverData->start_working_date,
                        'contractEndDate'=>$driverData->contract_end_date,
                        'finalClearanceDate'=>$driverData->final_clearance_date,
                        'email'=>$driverData->email,
                        'ssd'=>$driverData->ssd,
                        'currentVersionAndroid' =>  $verison[0]->driver,
                        'updatedAndroid' =>  $verison[0]->driver_state==0?false:true,
                        'currentVersionIos' =>  $verison[1]->driver,
                        'updatedIos' =>  $verison[1]->driver_state==0?false:true
                    ]; 

                    return $this -> returnData($data,'phone updated successfuly');
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
                $driverData = Auth::guard('driver-api') -> user();
                if($driverData){
                    if(Hash::check( $request->old_password, $driverData->password)){
                        
                        $driverData -> password =  Hash::make($request->new_password);
                        $driverData->save();
                        $driverData->api_token = $token;
                    
                        $verison = Version::all();
                        $data = (object)[
                            'id'=>(string)$driverData->id,
                            'name'=>$driverData->name,
                            'phone'=>$driverData->phone,
                            'account'=>(double)$driverData->account,
                            'api_token'=>$driverData->api_token,
                            'current_vechile'=>(string)$driverData->current_vechile,
                            'current_loc_latitude'=>$driverData->current_loc_latitude,
                            'current_loc_longtitude'=>$driverData->current_loc_longtitude,
                            'current_loc_name'=>$driverData->current_loc_name,
                            'persnol_photo'=>$driverData->persnol_photo,
                            'state'=>$driverData->state,
                            'driverRate'=>(string)$driverData->driver_rate,
                            'driverCounter'=>(string)$driverData->driver_counter,
                            'vechileRate'=>(string)$driverData->vechile_rate,
                            'vechileCounter'=>(string)$driverData->vechile_counter,
                            'timeRate'=>(string)$driverData->time_rate,
                            'timeCounter'=>(string)$driverData->time_counter,
                            'idCopyNo'=>(string)$driverData->id_copy_no,
                            'idExpirationDate'=>$driverData->id_expiration_date,
                            'licenseType'=>$driverData->license_type,
                            'licenseExpirationDate'=>$driverData->license_expiration_date,
                            'birthDate'=>(string)$driverData->birth_date,
                            'startWorkingDate'=>$driverData->start_working_date,
                            'contractEndDate'=>$driverData->contract_end_date,
                            'finalClearanceDate'=>$driverData->final_clearance_date,
                            'email'=>$driverData->email,
                            'ssd'=>$driverData->ssd,
                            'currentVersionAndroid' =>  $verison[0]->driver,
                            'updatedAndroid' =>  $verison[0]->driver_state==0?false:true,
                            'currentVersionIos' =>  $verison[1]->driver,
                            'updatedIos' =>  $verison[1]->driver_state==0?false:true
                        ]; 
    
                        return $this -> returnData($data,'password updated successfuly');
                    
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

    public function id_expiration_date_update(Request $request)
    {
        $request->validate([
            'id_expiration_date'    => ['required', 'string'],
        ]);
        $token = $request->header('auth-token');
        if($token){
            try{
                $driverData = Auth::guard('driver-api') -> user();
                if($driverData){
                    $driverData -> id_expiration_date = $request->id_expiration_date;
                    $driverData->save();
                    $driverData->api_token = $token;
                    $verison = Version::all();
                    $driverData -> version = $verison[0]->driver;
                    $driverData -> updating = $verison[0]->driver_state;
                    $driverData -> iosVersion = $verison[1]->driver;
                    $driverData -> iosUpdating = $verison[1]->driver_state;    
                    return $this -> returnData('driver' , $driverData,'id expiration date has ben updated successfuly');
                }
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return $this->returnError('', "Name is't not update");
            }
        }
        return $this->returnError('', "Name is't not update");     
    }

    public function send_message_driver_reset(Request $request)
    {

        $request->validate([
            'phone'    => ['required', 'string'],
            'password' => ['required', 'string'],
           
        ]);
        $drivers = Driver::where('phone', $request->phone)->get();
        if(count($drivers) > 0 ){
            $driverData = $drivers[0];
            $driverData -> password =  Hash::make($request->password);
            $driverData->save();
                $verison = Version::all();
                $data = (object)[
                    'id'=>(string)$driverData->id,
                    'name'=>$driverData->name,
                    'phone'=>$driverData->phone,
                    'account'=>(double)$driverData->account,
                    'api_token'=>$driverData->api_token,
                    'current_vechile'=>(string)$driverData->current_vechile,
                    'current_loc_latitude'=>$driverData->current_loc_latitude,
                    'current_loc_longtitude'=>$driverData->current_loc_longtitude,
                    'current_loc_name'=>$driverData->current_loc_name,
                    'persnol_photo'=>$driverData->persnol_photo,
                    'state'=>$driverData->state,
                    'driverRate'=>(string)$driverData->driver_rate,
                    'driverCounter'=>(string)$driverData->driver_counter,
                    'vechileRate'=>(string)$driverData->vechile_rate,
                    'vechileCounter'=>(string)$driverData->vechile_counter,
                    'timeRate'=>(string)$driverData->time_rate,
                    'timeCounter'=>(string)$driverData->time_counter,
                    'idCopyNo'=>(string)$driverData->id_copy_no,
                    'idExpirationDate'=>$driverData->id_expiration_date,
                    'licenseType'=>$driverData->license_type,
                    'licenseExpirationDate'=>$driverData->license_expiration_date,
                    'birthDate'=>(string)$driverData->birth_date,
                    'startWorkingDate'=>$driverData->start_working_date,
                    'contractEndDate'=>$driverData->contract_end_date,
                    'finalClearanceDate'=>$driverData->final_clearance_date,
                    'email'=>$driverData->email,
                    'ssd'=>$driverData->ssd,
                    'currentVersionAndroid' =>  $verison[0]->driver,
                    'updatedAndroid' =>  $verison[0]->driver_state==0?false:true,
                    'currentVersionIos' =>  $verison[1]->driver,
                    'updatedIos' =>  $verison[1]->driver_state==0?false:true
                ];
               
                return $this -> returnData($data,'rest password successfuly');   
             
        
            }else{
            return $this->returnError('100008', 'error in driver data');
        }
    }
    
    public function add_driver(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
            'img_profile' => 'required|mimes:jpeg,png,jpg,',
            'img_id' => 'required|mimes:jpeg,png,jpg,',
            'img_license' => 'required|mimes:jpeg,png,jpg,',
            'img_car_front' => 'required|mimes:jpeg,png,jpg,',
            'img_car_back' => 'required|mimes:jpeg,png,jpg,',
            'img_car_internal' => 'required|mimes:jpeg,png,jpg,',
        ]);

        $driverData = Driver::where('phone', $request->phone)->get();
        if(count($driverData) > 0 ){
            return $this->returnError('100006', 'هذه البيانات موجودة بالفعل');
        }
        else
        {
            $driver = new Driver;
            $driver->name = $request->name;
            $driver->password = '0' ;
            $driver->address = $request->address;
            $driver->phone = $request->phone;
            $driver->group_id = 1;
            $driver->add_date = Carbon::now();

            $driver->state = 'pending';

        
        if($request->hasFile('img_profile')){
            $file = $request->file('img_profile');
			$name = $file->getClientOriginalName();
			$ext  = $file->getClientOriginalExtension();
			$size = $file->getSize();
			$mim  = $file->getMimeType();
			$realpath = $file->getRealPath();
			$image = time().'.'.$ext;
			$file->move(public_path('images/drivers/personal_phonto'),$image);
			$driver->persnol_photo =  $image;
	              }
        $driver->save();

       
        $this->add_document($driver->id, 'صورة الهوية للسائق' , 'صورة الهوية للسائق تمت اضافتها عن طريق التطبيق', $request->file('img_id'), 'id');
        $this->add_document($driver->id, 'صورة رخصة القيادة للسائق' , 'صورة رخصة القيادة للسائق تمت اضافتها عن طريق التطبيق', $request->file('img_license'), 'lecincse');
        $this->add_document($driver->id, 'صورة امامية للمركبة' , 'صورة امامية للمركبة تمت اضافتها عن طريق التطبيق', $request->file('img_car_front'), 'front');
        $this->add_document($driver->id, 'صورة خلفية للمركبة' , 'صورة خلفية للمركبة تمت اضافتها عن طريق التطبيق', $request->file('img_car_back'), 'back');
        $this->add_document($driver->id, 'صورة داخلية للمركبة' , 'صورة داخلية للمركبة تمت اضافتها عن طريق التطبيق', $request->file('img_car_internal'), 'internal');


        $verison = Version::all();
        $driverData=$driver;
        $data = (object)[
            'id'=>(string)$driverData->id,
            'name'=>$driverData->name,
            'phone'=>$driverData->phone,
            'account'=>(double)$driverData->account,
            'api_token'=>$driverData->api_token,
            'current_vechile'=>(string)$driverData->current_vechile,
            'current_loc_latitude'=>$driverData->current_loc_latitude,
            'current_loc_longtitude'=>$driverData->current_loc_longtitude,
            'current_loc_name'=>$driverData->current_loc_name,
            'persnol_photo'=>$driverData->persnol_photo,
            'state'=>$driverData->state,
            'driverRate'=>(string)$driverData->driver_rate,
            'driverCounter'=>(string)$driverData->driver_counter,
            'vechileRate'=>(string)$driverData->vechile_rate,
            'vechileCounter'=>(string)$driverData->vechile_counter,
            'timeRate'=>(string)$driverData->time_rate,
            'timeCounter'=>(string)$driverData->time_counter,
            'idCopyNo'=>(string)$driverData->id_copy_no,
            'idExpirationDate'=>$driverData->id_expiration_date,
            'licenseType'=>$driverData->license_type,
            'licenseExpirationDate'=>$driverData->license_expiration_date,
            'birthDate'=>(string)$driverData->birth_date,
            'startWorkingDate'=>$driverData->start_working_date,
            'contractEndDate'=>$driverData->contract_end_date,
            'finalClearanceDate'=>$driverData->final_clearance_date,
            'email'=>$driverData->email,
            'ssd'=>$driverData->ssd,
            'currentVersionAndroid' =>  $verison[0]->driver,
            'updatedAndroid' =>  $verison[0]->driver_state==0?false:true,
            'currentVersionIos' =>  $verison[1]->driver,
            'updatedIos' =>  $verison[1]->driver_state==0?false:true
        ];
       
        return $this -> returnData($data,'register successfuly');
    }
    return $this->returnError('100007', 'حدث خطاء ما');

    }
    public function upload_document(Request $request)
    {
        $request->validate([
        
            'phone' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,',

        ]);

        $driverData = Driver::where('phone', $request->phone)->get();
        if(count($driverData)==0){
            return $this->returnError('100008', 'هذه البيانات موجودة بالفعل');
        }
        else
        {
            
        $this->add_document($driverData[0]->id, 'صورة الوثيقة للسائق' , 'صورة رخصة القيادة للسائق تمت اضافتها عن طريق التطبيق', $request->file('image'), 'criminal_document');
        return $this -> returnData('success upload document','register successfuly');
        }
 

    }

    public function block_account(Request $request)
    {
        $token = $request->header('auth-token');
        if($token){
            try {
                $driverData = Auth::guard('driver-api') -> user();
                $driverData -> state = 'deleted';
                $driverData -> remember_token = '';
                $driverData->update();

                JWTAuth::setToken($token)->invalidate(); //logout
            }catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e){
                return  $this -> returnError('100000','some thing went wrongs');
            }
            // catch(\Exception $ex){
            //     return $this->returnError($ex->getCode(), $ex->getMessage());
            // }   
            $data=true;

            
            return $this->returnData($data,"delete account succesfully");
        }else{
            return $this->returnError('100000', 'some thing is wrongs');
        }
    }

    public function add_document($driver_id, $title , $content, $file, $prefix)
    {
        $name = $file->getClientOriginalName();
        $ext  = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $mim  = $file->getMimeType();
        $realpath = $file->getRealPath();
        $image = $prefix.time().'.'.$ext;
        $file->move(public_path('images/drivers/documents'),$image);
        $document = new DriverDocuments;
        $document->document_type = $title;
        $document->content = $content;
        $document->add_date = Carbon::now();
        // $document->admin_id = Auth::guard('admin')->user()->id;
        $document->driver_id = $driver_id;
        $document->attached = $image;
        $document->save();
    }
}
