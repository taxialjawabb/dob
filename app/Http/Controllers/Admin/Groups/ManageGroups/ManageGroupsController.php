<?php

namespace App\Http\Controllers\Admin\Groups\ManageGroups;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Groups\Group;
use Carbon\Carbon;
use App\Models\Groups\GroupUser;
use App\Models\Groups\BoxGroup;
use App\Models\Groups\GroupsLicenses;

use App\Models\Groups\GroupBooking;
use Illuminate\Support\Facades\Auth;
use App\Models\Nathiraat\BoxNathriaat;
use App\Models\Driver;
use App\Models\Vechile;
use App\Models\Admin;
use App\Models\Groups\GroupNotes;

class ManageGroupsController extends Controller
{
    public function show_all_groups()
    {
        $groups = Group::with('manager:id,name')->get();
        $vechilePrice = \App\Models\Groups\GroupVechilePrice::find(1);
        return view('groups.manageGroups.showGroups', compact('groups', 'vechilePrice'));
    }

    public function add_show()
    {
        $users = \App\Models\Admin::select(['id', 'name'])->where('state', 'active')->get();
        return view('groups.manageGroups.addGroups', compact('users'));
    }


    public function save_add(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'city' => 'required|string',
            'commercial_register' => 'required|string',
            'expired_date_commercial_register' => 'required|string',
            'transportation_license_number' => 'required|string',
            'expired_date_transportation_license_number' => 'required|string',
            'municipal_license_number' => 'required|string',
            'expired_date_municipal_license_number' => 'required|string',
            'facility_type' => 'required|string|in:individual,company',
            'responsible_name' => 'required|string',
            'phone' => 'required|string',
            'manager_id' => 'required|numeric',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'city' => $request->city,
            'commercial_register' => $request->commercial_register,
            'expired_date_commercial_register' => $request->expired_date_commercial_register,
            'transportation_license_number' => $request->transportation_license_number,
            'expired_date_transportation_license_number' => $request->expired_date_transportation_license_number,
            'municipal_license_number' => $request->municipal_license_number,
            'expired_date_municipal_license_number' => $request->expired_date_municipal_license_number,
            'facility_type' => $request->facility_type,
            'responsible_name' => $request->responsible_name,
            'phone' => $request->phone,
            'add_date' => Carbon::now(),
            'add_by' => Auth::guard('admin')->user()->id,
            'manager_id' => $request->manager_id,
            'vechile_counter' => $request->vechile_counter,
            // 'group_price' => $request->group_price,
            // 'renew_date' => Carbon::now(),
        ]);
        GroupUser::create([
            'user_id' => $request->manager_id,
            'group_id' => $group->id,
            'state' => 'active',
        ]);
        return redirect()->route("manage.groups.show");

    }


    public function update_show(Group $group)
    {
        if ($this->hasPermissionData($group->id) == false)
                     return back();
        $users = Admin::select(['id', 'name'])->where('state', 'active')->get();
        return view('groups.manageGroups.updateGroups', compact('users', 'group'));
    }

    public function update_save(Request $request,Group $group)
    {
        if ($this->hasPermissionData($group->id) == false)
                     return back();
        $request->validate([
            'name' => 'required|string',
            'city' => 'required|string',
            'commercial_register' => 'required|string',
            'expired_date_commercial_register' => 'required|string',
            'transportation_license_number' => 'required|string',
            'expired_date_transportation_license_number' => 'required|string',
            'municipal_license_number' => 'required|string',
            'expired_date_municipal_license_number' => 'required|string',
            'facility_type' => 'required|string|in:individual,company',
            'responsible_name' => 'required|string',
            'phone' => 'required|string',
            'manager_id' => 'required|numeric',
        ]);
        // return $request->all();
        $group->update([
            'name' => $request->name,
            'city' => $request->city,
            'commercial_register' => $request->commercial_register,
            'expired_date_commercial_register' => $request->expired_date_commercial_register,
            'transportation_license_number' => $request->transportation_license_number,
            'expired_date_transportation_license_number' => $request->expired_date_transportation_license_number,
            'municipal_license_number' => $request->municipal_license_number,
            'expired_date_municipal_license_number' => $request->expired_date_municipal_license_number,
            'facility_type' => $request->facility_type,
            'responsible_name' => $request->responsible_name,
            'phone' => $request->phone,
            'add_date' => Carbon::now(),
            'add_by' => Auth::guard('admin')->user()->id,
            'manager_id' => $request->manager_id,
            // 'vechile_counter' => $request->vechile_counter,
            // 'group_price' => $request->group_price,
            // 'renew_date' => Carbon::now(),
        ]);
        GroupUser::updateOrCreate([
            'user_id' => $request->manager_id,
        ],[
            'group_id' => $group->id,
            'state' => 'active',
        ]);
        $request->session()->flash('status', 'تم تعديل المجموعة بنجاح');

        return redirect()->route("manage.groups.show");

    }

    public function state_show(Group $group)
    {
        if ($this->hasPermissionData($group->id) == false)
                     return back();
        return view('groups.manageGroups.stateGroupChange', compact('group'));
    }

    public function state_save(Request $request , Group $group)
    {
        if ($this->hasPermissionData($group->id) == false)
                     return back();
        $request->validate([
            'content' => 'required|string',
        ]);
        $title = '';
        if ($group->state == 'active'){
            $title = ' أستبعاد هذه المجموعة';
            $group->state= "blocked";
        }
        else{
            $group->state= "active";
            $title = ' إلغاء استبعاد هذه المجموعة';
        }
        $group->save();
        GroupNotes::create([
            'note_type' => $title,
            'content' => $request->content,
            'add_date' => Carbon::now(),
            'added_by' => Auth::guard('admin')->user()->id,
            'group_id' => $group->id
        ]);
        session()->flash('status', 'تم '.$title . ' مجموعة'. $group->name);
        return redirect()->route("manage.groups.show");
    }

    public function license_show($type)
    {
        $data = [];
        if($type == 'accepted'){
            $data = \DB::select("select groups_licenses.id,  groups_licenses.type , groups_licenses.state, expire_date, attached , groups.name
                                    from groups_licenses left join documents_group on groups_licenses.document_id = documents_group.id
                                    left join groups on documents_group.group_id = groups.id where  groups_licenses.state = 'accepted';");

        }
        else if($type == 'rejected'){
            $data = \DB::select("select groups_licenses.id,  groups_licenses.type , groups_licenses.state, expire_date, attached , groups.name
                                    from groups_licenses left join documents_group on groups_licenses.document_id = documents_group.id
                                    left join groups on documents_group.group_id = groups.id where  groups_licenses.state = 'rejected';");
        }
        else{
            $data = \DB::select("select groups_licenses.id,  groups_licenses.type , groups_licenses.state, expire_date, attached , groups.name
                                    from groups_licenses left join documents_group on groups_licenses.document_id = documents_group.id
                                    left join groups on documents_group.group_id = groups.id where  groups_licenses.state = 'pending';");
        }

        return view('groups.manageGroups.showLicensesRequestGroups', compact('data', 'type'));
    }

    public function license_change($type, $id)
    {

        $license = GroupsLicenses::find($id);
        if($license == null ){
            session()->flash('error', 'خطاء فى أرسال بيانات الترخيص');
            return back();

        }
        if($type == 'accepted'){
            $document = \App\Models\Groups\GroupDocuments::with('group')->find($license->document_id);
            $group = $document->group;

            switch ($license->type) {
                case 'commercial_register':
                    $group->expired_date_commercial_register = $license->expire_date;
                    break;
                case 'transportation_license_number':
                    $group->expired_date_transportation_license_number = $license->expire_date;
                    break;
                case 'municipal_license_number':
                    $group->expired_date_municipal_license_number = $license->expire_date;
                    break;
                default:
                    break;
            }
            $license->state ="accepted";
            $license->accept_date = Carbon::now();
            $license->accepted_by =  Auth::guard('admin')->user()->id;
            $license->save();
            $group->save();
            session()->flash('status', 'تم قبول الترخيص بنجاح');
        }
        else if($type == 'rejected'){

            $license->state ="rejected";
            $license->accept_date = Carbon::now();
            $license->accepted_by =  Auth::guard('admin')->user()->id;
            $license->save();
            session()->flash('error', 'تم رفض الترخيص');
        }else{
            session()->flash('error', 'خطاء فى أرسال حالة الترخيص');
        }
        return back();
    }
}
