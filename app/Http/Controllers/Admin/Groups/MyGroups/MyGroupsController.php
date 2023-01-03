<?php

namespace App\Http\Controllers\Admin\Groups\MyGroups;

use App\Http\Controllers\Controller;
use App\Models\Contract\Contract;
use App\Models\Groups\Group;
use App\Models\Groups\GroupUser;
use App\Models\Groups\GroupDocuments;
use App\Models\Groups\GroupsLicenses;
use App\View\Components\Driver;
use Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB as FacadesDB;
use PhpParser\Node\Stmt\GroupUse;
use App\Models\Groups\GroupBooking;


class MyGroupsController extends Controller
{

    public function show_my_group()
    {

        $groups = Group::with('manager:id,name')->whereIn(
            'id',
            function ($query) {
                $query->select('group_id')
                      ->from('groups_user')->where('state', 'active')
                      ->where('user_id', Auth::guard('admin')->user()->id);

            }
        )->get();

        $vechilePrice = \App\Models\Groups\GroupVechilePrice::find(1);
        // return $groups;
        return view('groups.myGroups.showOwnerGroups', compact('groups' ,'vechilePrice'));
    }




    public function show_box($type , $id)
    {
        if ($this->hasPermissionData($id) == false)
                return back();
        $group = Group::find($id);
        if($group === null){
            return back();
        }
        if($type === 'spend'){
            $bonds = DB::select("
            select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
            boxd.descrpition,boxd.add_date,admins.name as admin_name
            from box_nathriaat as boxd left join   stakeholders  on boxd.stakeholders_id = stakeholders.id
            left join  admins on  boxd.add_by = admins.id  where
            stakeholders.id = 8  and boxd.bond_type = 'spend' and boxd.foreign_type = 'group' and boxd.foreign_id = ?
            ", [$id]);
            return view('groups.shared.box.showBoxGroup', compact('bonds','type', 'group'));
        }
        else if($type === 'take'){
            $bonds = DB::select("
            select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
            boxd.descrpition,boxd.add_date,admins.name as admin_name
            from box_nathriaat as boxd left join   stakeholders  on boxd.stakeholders_id = stakeholders.id
            left join  admins on  boxd.add_by = admins.id  where
            stakeholders.id = 8  and boxd.bond_type = 'take' and boxd.foreign_type = 'group' and boxd.foreign_id = ?
            ", [$id]);
            return view('groups.shared.box.showBoxGroup', compact( 'bonds','type', 'group'));
        }
        else{
            return back();
        }
    }



    public function show_my_group_details(Group $group)
    {
        if ($this->hasPermissionData($group->id) == false )
             return back();

        if (($group->vechile_counter ==0||$group->vechile_counter ==null)&&Auth::user()->isAbleTo('manage_group')==false)
             return back();

            return view('groups.shared.showGroupsDetails', compact('group'));



    }


    public function renew_show(Group $group)
    {
        $groupuser = GroupUser::where('user_id' , Auth::guard('admin')->user()->id)->where('group_id', $group->id)->get();



        if(\Auth::user()->isAbleTo('manage_group'))
        {

            $dateNow = new \DateTime('now');
            $dateNow->modify('last day of this month');
            $end_month = $dateNow->format('Y-m-d');
            $startDateCarbon = Carbon::today();
            $endDateCarbon = Carbon::parse($end_month)->addDay();
            $days = $startDateCarbon->diffInDays($endDateCarbon);
            $vechilePrice = \App\Models\Groups\GroupVechilePrice::find(1);
            return view('groups.manageGroups.renewGroup', compact('vechilePrice', 'days', 'group'));

        }
        else {
            if ($group->state != "active"||count($groupuser) == 0)
                       return back();
        $dateNow = new \DateTime('now');
        $dateNow->modify('last day of this month');
        $end_month = $dateNow->format('Y-m-d');
        $startDateCarbon = Carbon::today();
        $endDateCarbon = Carbon::parse($end_month)->addDay();
        $days = $startDateCarbon->diffInDays($endDateCarbon);
        $vechilePrice = \App\Models\Groups\GroupVechilePrice::find(1);
        return view('groups.manageGroups.renewGroup', compact('vechilePrice', 'days', 'group'));
                }
    }

    public function renew_save(Request $request, Group $group)
    {
        if ($this->hasPermissionData($group->id) == false)
                return back();
        $request->validate([
            'daily_price_vechile' => 'required|numeric',
            'days' => 'required|numeric',
            'vechile_counter' => 'required|numeric',
            'payment_type' => 'required|string|in:cash,bank transfer,internal transfer,selling points,electronic payment',
            'group_price' => 'required|numeric',
        ]);

        $dateNow = new \DateTime('now');
        $dateNow->modify('last day of this month');
        $end_month = $dateNow->format('Y-m-d');

        $group->update([
            'vechile_counter' =>  $group->vechile_counter +$request->vechile_counter,
            'group_price' => $group->group_price +$request->group_price,
            'renew_date' => $end_month,
        ]);
        GroupBooking::create([
            'added_by' => Auth::guard('admin')->user()->id,
            'group_id' => $group->id,
            'vechile_counter' => $request->vechile_counter,
            'booking_price' => $request->group_price,
            'start_date' => Carbon::now(),
            'end_date' => $end_month,
        ]);
        $boxNathriaat = new \App\Models\Nathiraat\BoxNathriaat;
        $boxNathriaat->stakeholders_id = 8;
        $boxNathriaat->foreign_type = 'group';
        $boxNathriaat->foreign_id = $group->id;
        $boxNathriaat->bond_type = 'take';
        $boxNathriaat->payment_type = $request->payment_type;
        $boxNathriaat->money = $request->group_price;
        $boxNathriaat->tax = 0;
        $boxNathriaat->total_money = $request->group_price;
        $boxNathriaat->bond_state = 'waiting';
        $boxNathriaat->descrpition = 'أضافة مجموعة جديدة وجحز الاشتراك لنهاية الشهر عدد ايام: ' . $request->days . ' سعر الإشتراك: ' . $request->group_price . ' ريال سعودى';
        $boxNathriaat->add_date = Carbon::now();
        $boxNathriaat->add_by = Auth::guard('admin')->user()->id;
        $boxNathriaat->save();
        session()->flash('status', 'تم تعديل سعة المجموعة بنجاح');
        return redirect('my/groups/show');
    }

    public function license_show(Group $group)
    {
        $groupuser = GroupUser::where('user_id' , Auth::guard('admin')->user()->id)->where('group_id', $group->id)->where('state', 'active')->get();



        if (Auth::user()->isAbleTo('manage_group')) {

            return view('groups.myGroups.licenseRenew', compact('group'));
        } else {


            if ($group->state != "active"||count($groupuser) == 0)
            return back();

            return view('groups.myGroups.licenseRenew', compact('group'));
        }
    }

    public function license_save(Request $request, Group $group)
    {

        $request->validate([
            'document_type' => 'required|string|in:commercial_register,transportation_license_number,municipal_license_number',
            'content' => 'required|string',
            'expire_date' => 'required|string',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        ]);
        $file = $request->file('image');
        $name = $file->getClientOriginalName();
        $ext = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $mim = $file->getMimeType();
        $realpath = $file->getRealPath();
        $image = time() . '.' . $ext;
        $file->move(public_path('images/groups/documents'), $image);
        $type = '';
        if ($request->document_type == 'commercial_register') {
            $type = 'رقم رخصة السجل التجاري';
        } else if ($request->document_type == 'transportation_license_number') {
            $type = 'رقم ترخيص هيئة النقل ';
        } else if ($request->document_type == 'municipal_license_number') {
            $type = 'رقم رخصة البلدية ';
        }
        $license = GroupDocuments::create([
            'document_type' => $type,
            'content' => $request->content,
            'add_date' => Carbon::now(),
            'added_by' => Auth::guard('admin')->user()->id,
            'group_id' => $group->id,
            'attached' => $image,
        ]);

        GroupsLicenses::create([
            'type' => $request->document_type,
            'state' => 'pending',
            'expire_date' => $request->expire_date,
            'document_id' => $license->id,
        ]);

        $request->session()->flash('status', 'تم اضافة مستند للمجموعة');
        return view('groups.myGroups.licenseRenew', compact('group'));
    }

}
