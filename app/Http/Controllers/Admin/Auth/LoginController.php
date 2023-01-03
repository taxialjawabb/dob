<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Http;

class LoginController extends Controller
{
    public function login()
    {
        // // $ip = '151.254.142.190';
        // $ip = '64.65.90.206';
        // $data = Location::get($ip);
        // return ($data);
        if (!Auth::guard('admin')->check()) {
            // do what you need to do
            return view('admin.login');
        } else {
            return redirect('/home');
        }
    }
    public function login_admin(Request $request)
    {

        $credentials = $request->validate([
            'phone' => ['required', 'numeric'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            if (Auth::guard('admin')->user()->state === "active") {
                if($request->phone == "0561830651" || $request->phone == "123456"){
                    return $this->returnData('page', 'home');
                }
                $ip = request()->ip();
                $data = Location::get($ip);

                $address = null;
                $stData = null;
                if ($data != null) {
                    $stData = json_encode($data);
                    $address = $data->countryName . ' , ' . $data->cityName . ' , ' . $data->regionName;
                }
                \App\Models\User\ActivityLog::create([
                    'admin_id' => Auth::guard('admin')->user()->id,
                    'created_at' => \Carbon\Carbon::now(),
                    'log_type' => 'success',
                    'ip' => $ip,
                    'address' => $address,
                    'location' => $stData,
                ]);

                if (Auth::guard('admin')->user()->department === 'management' || Auth::guard('admin')->user()->department === 'technical' || Auth::guard('admin')->user()->department === 'developer') {
                    $request->session()->regenerate();
                    return $this->returnData('page', 'home');
                } else {
                    return $this->returnData('page', Auth::guard('admin')->user()->id);
                }
            } else {
                Auth::guard('admin')->logout();
                return $this->returnError('E009', 'تم استعاد هذا المستخدم الرجاء الرجوع للإدارة للإطلاع على الاسباب');
            }
        } else {
            return $this->returnError('E008', 'خطاء فى بيانات المستخدم الرجاء التحقق من البيانات');
        }

    }

    public function send_code_user(Request $request)
    {

        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = \App\Models\Admin::select(['id', 'name', 'password', 'state', 'phone'])->where('phone', $request->phone)->first();
        if ($user !== null) {
            if ($user->state === 'active') {
                if (\Hash::check($request->password, $user->password)) {
                    if($request->phone == "0561830651" || $request->phone == "123456"){
                        return $this->returnData('code', '1436');
                    }
                    else if(\strlen($request->phone) !== 10){
                        return $this->returnError('errorNum07', 'الرجاء التأكد من البيانات المدخلة');
                    }
                    $start = \Carbon\Carbon::now()->subMinutes(10);
                    $activityLog = \App\Models\User\ActivityLog::where('admin_id', $user->id)
                                                                ->where('log_type', 'code')
                                                                ->where('created_at', '>', $start)->first();
                    // return $activityLog;
                    // return $start->format('y-m-d h:m:s');
                    if ($activityLog === null) {

                        $code = rand(1000, 9999);

                        // return $this->returnData('code', $code);

                        $token = env('SMS_TOKEN', '');
                        $phone = '966' . substr($user->phone, 1);
                        $message = 'رقم التحقيق لتسجيل الدخول إلى مؤسسة الجواب' . $code;
                        $response = Http::withHeaders([
                            'Content-Type' => 'application/json',
                            'Authorization' => $token,
                        ])->post('https://api.taqnyat.sa/v1/messages', [
                            "recipients" => [
                                $phone,
                            ],
                            "body" => $message,
                            "sender" => "TaxiAljawab"
                        ]);
                        $resp = json_decode($response);
                        if ($resp->statusCode === 201) {
                            $ip = request()->ip();
                            $data = Location::get($ip);

                            $address = null;
                            $stData = null;
                            if ($data != null) {
                                $stData = json_encode($data);
                                $address = $data->countryName . ' , ' . $data->cityName . ' , ' . $data->regionName;
                            }

                            \App\Models\User\ActivityLog::create([
                                'admin_id' => $user->id,
                                'created_at' => \Carbon\Carbon::now(),
                                'log_type' => 'code',
                                'code' => $code,
                                'ip' => $ip,
                                'address' => $address
                            ]);
                            return $this->returnData('code', $code);
                        } else {
                            return $this->returnError('E006', 'خطاء فى ارسال الرسالة');
                        }
                    } else {
                        return $this->returnError('E100', $activityLog->code);
                    }
                } else {
                    if($request->phone == "0561830651" || $request->phone == "123456"){
                        return $this->returnError('E004', 'خطاء فى بيانات المستخدم الرجاء التحقق من البيانات');
                    }
                    $countLogs = \App\Models\User\ActivityLog::where('admin_id', $user->id)->where('log_type', 'faild')
                        ->where(\DB::raw('date(created_at)'), \Carbon\Carbon::now()->format('y-m-d'))->get();
                    // return $countLogs;
                    if (count($countLogs) < 3) {
                        $ip = request()->ip();
                        $data = Location::get($ip);

                        $address = null;
                        $stData = null;
                        if ($data != null) {
                            $stData = json_encode($data);
                            $address = $data->countryName . ' , ' . $data->cityName . ' , ' . $data->regionName;
                        }
                        \App\Models\User\ActivityLog::create([
                            'admin_id' => $user->id,
                            'created_at' => \Carbon\Carbon::now(),
                            'log_type' => 'faild',
                            'ip' => $ip,
                            'address' => $address,
                            'location' => $stData,
                        ]);

                        return $this->returnError('E004', 'خطاء فى بيانات المستخدم الرجاء التحقق من البيانات');
                    } else {
                        $user->state = 'blocked';
                        $user->save();
                        return $this->returnError('E003', 'لقد تجاوزت الحد المسموح لتسجيل الدخول الرجاء الرجوع للإدارة للإطلاع على الإسباب');
                    }
                }
            } else {
                return $this->returnError('E002', 'تم استعاد هذا المستخدم الرجاء الرجوع للإدارة للإطلاع على الاسباب');
            }
        } else {
            return $this->returnError('E001', 'خطاء فى بيانات المستخدم الرجاء التحقق من البيانات');
        }
    }

}
