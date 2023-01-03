<?php

namespace App\Http\Controllers\Admin\Groups\myGroups;

use App\Http\Controllers\Controller;
use App\Models\Groups\Group;
use App\Models\Groups\GroupBooking;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class renewGroupController extends Controller
{
    public function renew_save(Group $group)
    {



        if ($this->hasPermissionData($group->id) == false)
             return back(); 
        if (($group->vechile_counter ==0||$group->vechile_counter ==null)&&Auth::user()->isAbleTo('manage_group')==false)
             return back(); 
     
        $end_month = Carbon::now()->endOfMonth()->format('Y-m-d');
        $renew_date = Carbon::parse($group->renew_date)->format('Y-m-d');
        $todayDate = Carbon::now()->format('Y-m-d');


        if ($renew_date < $todayDate)
         {
            $startDateCarbon = Carbon::today();
            $endDateCarbon = Carbon::parse($end_month)->addDay();
            $days = $startDateCarbon->diffInDays($endDateCarbon);

            $vechilePrice = \App\Models\Groups\GroupVechilePrice::find(1);
            $new_price = $days * $group->vechile_counter * $vechilePrice->vechile_price;


            $group->update([
                'group_price' => $new_price,
                'renew_date' => $end_month,
            ]);
            GroupBooking::create([
                'added_by' => Auth::guard('admin')->user()->id,
                'group_id' => $group->id,
                'vechile_counter' => $group->vechile_counter,
                'booking_price' => $new_price,
                'start_date' => Carbon::now(),
                'end_date' => $end_month,
            ]);
            $boxNathriaat = new \App\Models\Nathiraat\BoxNathriaat;
            $boxNathriaat->stakeholders_id = 8;
            $boxNathriaat->foreign_type = 'group';
            $boxNathriaat->foreign_id = $group->id;
            $boxNathriaat->bond_type = 'take';
            $boxNathriaat->payment_type = 'cash';
            $boxNathriaat->money = $new_price;
            $boxNathriaat->tax = 0;
            $boxNathriaat->total_money = $new_price;
            $boxNathriaat->bond_state = 'waiting';
            $boxNathriaat->descrpition = 'أضافة مجموعة جديدة وجحز الاشتراك لنهاية الشهر عدد ايام: ' . $days . ' سعر الإشتراك: ' . $new_price . ' ريال سعودى';
            $boxNathriaat->add_date = Carbon::now();
            $boxNathriaat->add_by = Auth::guard('admin')->user()->id;
            $boxNathriaat->save();
            session()->flash('status', 'تم تجديد  المجموعة بنجاح');
            return back();
        } else {
            session()->flash('status', 'لم يتم التجديد المجموعه ساريه حتي الان');
            return back();
        }

    }
}
