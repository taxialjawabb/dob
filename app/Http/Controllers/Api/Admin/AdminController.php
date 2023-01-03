<?php

namespace App\Http\Controllers\Api\Admin;
use App\Traits\GeneralTrait;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    use GeneralTrait;
    public function login(Request $request )
    {
        try{
            $validator = $request->validate([
                'phone_no' => 'required',
                'password' => 'required',
            ]);
    
            $credentials = $request->only(['phone_no', 'password']);

            $token = Auth::guard('admin-api')->attempt($credentials);
            if(!$token)
                return $this->returnError('E001','بيانات الدخول غير صحيحة');


            //return $this -> returnData('token' , $token);

            $admin = Auth::guard('admin-api') -> user();
            $admin -> api_token = $token;
            //return token
            return $this -> returnData('admin' , $admin);
    
            return $request->all();           
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());

        }    
    }

    public function logout(Request $request)
    {
        $token = $request->header('auth_token');
        if($token){
            try {

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
}
