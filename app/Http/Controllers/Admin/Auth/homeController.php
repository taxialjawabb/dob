<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Location\Facades\Location;

class homeController extends Controller
{
    public function logout()
    {

        if(Auth::guard('admin')->user()->phone == "0561830651" || Auth::guard('admin')->user()->phone == "123456"){
            Auth::logout();
            return redirect('control/panel/login');
        }
        $ip = request()->ip();
        $data = Location::get($ip);
        $address = null;
        $stData = null;
        if ($data != null) {
            $stData = json_encode($data);
            $address = $data->countryName . ' , ' . $data->cityName . ' , ' . $data->regionName;
        }
        $startSession = \App\Models\User\ActivityLog::select(['id'])->where('admin_id', Auth::guard('admin')->user()->id)->where('log_type', 'success')->orderBy('created_at', 'desc')->first();
        $id = null;
        if($startSession !== null){
            $id = $startSession->id;
        }
        \App\Models\User\ActivityLog::create([
            'admin_id' => Auth::guard('admin')->user()->id,
            'created_at' => \Carbon\Carbon::now(),
            'log_type' => 'logout',
            'code' => $id,
            'ip' => $ip,
            'address' => $address,
            'location' => $stData,
        ]);
        Auth::logout();
        return redirect('control/panel/login');
    }
    public function home()
    {

        $admin = Auth::guard('admin') -> user();
        // $admin->attachPermission('user_group');
        // $admin->detachPermission("user_manage");
        // return dd($admin->allPermissions());
        if($admin !== null){

            return view('home');
        }
        else{
            return back();
        }
    }
}
