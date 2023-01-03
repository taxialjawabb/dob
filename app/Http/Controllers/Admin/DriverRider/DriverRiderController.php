<?php

namespace App\Http\Controllers\Admin\DriverRider;

use App\Http\Controllers\Controller;
use App\Models\PolicyTerms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriverRiderController extends Controller
{
    public function show_count()
    {

        $data = DB::select("
                        select address , sum(rider_count) as rider_count, sum(driver_count) as driver_count from
                        (
                        select driver.address as address , 0  as rider_count , count(driver.address) as driver_count from driver group by driver.address
                        union all
                        select rider.address as address , count(rider.address) as rider_count , 0 as driver_count from rider group by rider.address
                        ) t group by address ;
                    ");
        // return $data;
        return view('driver.reports.countNumber', compact('data'));

    }

    public function show_privacy_policy($belong)
    {
        if($belong == 'policy' || $belong == 'terms'){
            $data = PolicyTerms::with('add_by')->where('belong_to', $belong)->get();
            return view('privacy_policy.showPrivacy', compact('data' , 'belong'));
        }
        else{
            return back();
        }
    }
    public function add_privacy_policy()
    {
        return view('privacy_policy.addPrivacy');
    }
    public function save_privacy_policy(Request $request)
    {
        $request->validate([
            'belong_to' => 'required|string|in:policy,terms',
            'type' => 'required|string|in:driver,rider,all',
            'en_title' => 'required|string',
            'ar_title' => 'required|string',
            'en_content' => 'required|string',
            'ar_content' => 'required|string',
        ]);
        PolicyTerms::create([
            "added_by" => Auth::guard('admin')->user()->id,
            "added_date" => \Carbon\Carbon::now(),
            "belong_to" => $request->belong_to,
            "type" => $request->type,
            "en_title" => $request->en_title,
            "ar_title" => $request->ar_title,
            "en_content" => $request->en_content,
            "ar_content" => $request->ar_content,
        ]);

        session()->flash('status', 'تم الحفظ بنجاح ');
        return redirect('privacy/policy/manage/show/'.$request->belong_to);
    }

    public function update_privacy_policy($id)
    {
        $policy = PolicyTerms::find($id);
        if ($policy !== null) {
            return view('privacy_policy.updatePrivacy', compact('policy'));
        } else {
            session()->flash('error', 'خطاء فى البيانات ');
            return back();
        }
    }

    public function update_privacy_policy_save(Request $request)
    {

        $request->validate([
            'policy_id' => 'required|integer',
            'belong_to' => 'required|string|in:policy,terms',
            'type' => 'required|string|in:driver,rider,all',
            'en_title' => 'required|string',
            'ar_title' => 'required|string',
            'en_content' => 'required|string',
            'ar_content' => 'required|string',
        ]);
        $policy = PolicyTerms::find($request->policy_id);

        if ($policy !== null) {
                $policy->added_by = Auth::guard('admin')->user()->id ;
                $policy->added_date = \Carbon\Carbon::now() ;
                $policy->belong_to = $request->belong_to;
                $policy->type = $request->type ;
                $policy->en_title = $request->en_title ;
                $policy->ar_title = $request->ar_title ;
                $policy->en_content = $request->en_content ;
                $policy->ar_content = $request->ar_content ;
                $policy->save();
            session()->flash('status', 'تم التعديل بنجاح ');
            return redirect('privacy/policy/manage/show/'.$request->belong_to);
        } else {
            session()->flash('error', 'خطاء فى البيانات ');
            return back();
        }
    }

    public function details($id)
    {
        $policy = PolicyTerms::find($id);
        if ($policy !== null) {
            return view('privacy_policy.detials', compact('policy'));
        } else {
            session()->flash('error', 'خطاء فى البيانات ');
            return back();
        }
    }

    public function privacy_policy($type = null, $lang = null){
        if($type == 'driver' || $type == 'rider'){
            $belong = "policy";
            $policies = PolicyTerms::where('belong_to', 'policy')->where(function($query) use ($type){
                $query->where('type', $type)->orWhere('type', 'all');
            })->get();
            if($lang == 'ar' || $lang == 'arb'|| $lang == 'Arb'){
                return view('privacy_policy.privacyArb', compact('policies', 'type', 'belong'));
            }
            else{
                return view('privacy_policy.privacyEng', compact('policies', 'type', 'belong'));
            }
        }
        else{
            return back();
        }
    }
    public function terms_conditions($type = null, $lang = null){
        if($type == 'driver' || $type == 'rider'){
            $belong = "terms";
            $policies = PolicyTerms::where('belong_to', 'terms')->where(function($query) use ($type){
                $query->where('type', $type)->orWhere('type', 'all');
            })->get();
            if($lang == 'ar' || $lang == 'arb'|| $lang == 'Arb'){
                return view('privacy_policy.privacyArb', compact('policies', 'type', 'belong'));
            }
            else{
                return view('privacy_policy.privacyEng', compact('policies', 'type', 'belong'));
            }
        }
        else{
            return back();
        }
    }
}
