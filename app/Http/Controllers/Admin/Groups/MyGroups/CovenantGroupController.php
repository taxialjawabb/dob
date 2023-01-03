<?php

namespace App\Http\Controllers\Admin\Groups\myGroups;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Groups\Covenants\GroupsCovenant;
use App\Models\Groups\Covenants\GroupsCovenantNotes;
use App\Models\Groups\Covenants\GroupsCovenantRecored;
use App\Models\Groups\Group;
use App\Models\Groups\GroupUser;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CovenantGroupController extends Controller
{

    public function show(Group $group)
    {

        if ($this->hasPermissionData($group->id) == false) {
            return back();
        }

        $covenants = GroupsCovenant::with(['addedby', 'deliveredTo'])->where('group_id', $group->id)->get();

        return view('groups.myGroups.covanent.showMyCovanent', compact('covenants', 'group'));
    }
    public function show_add(Group $group)
    {
        return view('groups.myGroups.covanent.addCovenant', compact('group'));
    }

    public function save_add(Request $request, Group $group)
    {

        $request->validate([
            "covenant_name" => "required|string",
            'serial_number' => "required|string",
        ]);

        if ($this->hasPermissionData($request->id) == false) {
            return back();
        }

        if ($group != null) {

            $item = GroupsCovenant::find($request->serial_number);
            if ($item == null) {
                $new_item = new GroupsCovenant;
                $new_item->covenant_name = $request->covenant_name;
                $new_item->serial_number = $request->serial_number;
                $new_item->add_date = \Carbon\Carbon::now();
                $new_item->added_by = Auth::guard('admin')->user()->id;
                $new_item->state = 'waiting';
                $new_item->delivery_date = \Carbon\Carbon::now();
                $new_item->group_id = $group->id;
                $new_item->save();
                session()->flash('status', ' تم اضافات العهده بنجاح ');
                return redirect()->route('my.groups.covenant.show', $group);

            } else {
                $request->session()->flash('status', ' خطا ف بيانات العهده هذا الرقم  المسلسل موجود بالفعل ');
                return back();
            }

        } else {
            $request->session()->flash('status', ' خطا ف بيانات المجموعه ');
            return back();
        }

    }

    public function show_delivering(Group $group)
    {

        if ($this->hasPermissionData($group->id) == false) {
            return back();
        }

        $covenants = GroupsCovenant::where('group_id', $group->id)->get();
        $users = GroupUser::with('users_group')->where('state', 'active')->where('group_id', $group->id)->get();
        return view('groups.myGroups.covanent.deliveryCovanent', compact('covenants', 'users', 'group'));
    }

    public function show_delivering_driver(Group $group)
    {
        if ($this->hasPermissionData($group->id) == false) {
            return back();
        }
        $covenants = GroupsCovenant::where('group_id', $group->id)->where('state', 'waiting')
            ->where('driver_id', null)->get();
        $users = Driver::where('state', 'active')->where('group_id', $group->id)->get();
        return view('groups.myGroups.covanent.deliveryCovanentDriver', compact('covenants', 'users', 'group'));
    }

    public function save_delivering(Request $request, Group $group)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'user_id' => 'exists:admins,id',
            'covenant' => 'required|array|min:1',
            'covenant.*' => 'required|exists:groups_covenant,id',
        ]);

        $covenantItems = GroupsCovenant::whereIn("id", $request->covenant)->get();

        foreach ($covenantItems as $covenantItem) {
            $prevUserReceive = GroupsCovenantRecored::where('groups_covenant_id', $covenantItem->id)
                ->whereNull('receive_by')->whereNull('receive_date')->first();

            if ($prevUserReceive !== null) {
                if ($prevUserReceive->delivery_type == 'user' && $prevUserReceive->delivery_by == $request->user_id) {
                    $request->session()->flash('status', 'هذه العهده بالفعل فى حوذ المستخدم ');
                    continue;
                }
                $prevUserReceive->update([
                    "receive_date" => Carbon::now(),
                    "receive_type" => "user",
                    "receive_by" => $request->user_id,
                ]);
            }

            $covenantItem->update([
                "state" => "waiting",
                "delivery_date" => null,
                "driver_id" => null,
            ]);

            $covenantRecord = new GroupsCovenantRecored;
            $covenantRecord->delivery_type = 'user';
            $covenantRecord->groups_covenant_id = $covenantItem->id;
            $covenantRecord->delivery_date = Carbon::now();
            $covenantRecord->delivery_by = $request->user_id;
            $covenantRecord->added_by = Auth::guard('admin')->user()->id;
            $covenantRecord->save();

            $request->session()->flash('status', 'تم تسليم العهد للمستخدم بنجاح');
        }
        return redirect()->route('my.groups.covenant.show', $group);

    }

    public function save_delivering_driver(Request $request, Group $group)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'user_id' => 'exists:driver,id',
            'covenant' => 'required|array|min:1',
            'covenant.*' => 'required|exists:groups_covenant,id',
        ]);

        $covenantItems = GroupsCovenant::whereIn("id", $request->covenant)->get();
        foreach ($covenantItems as $covenantItem) {
            $prevUserReceive = GroupsCovenantRecored::where('groups_covenant_id', $covenantItem->id)
                ->whereNull('receive_by')->whereNull('receive_date')->first();
            if ($prevUserReceive !== null) {
                if ($prevUserReceive->delivery_type == 'driver' && $prevUserReceive->delivery_by == $request->user_id) {
                    $request->session()->flash('status', 'هذه العهده بالفعل فى حوذ السائق ');
                    continue;
                }
                $prevUserReceive->update([
                    "receive_date" => Carbon::now(),
                    "receive_type" => "driver",
                    "receive_by" => $request->user_id,
                ]);
            }

            $covenantItem->update([
                "state" => "active",
                "delivery_date" => Carbon::now(),
                "driver_id" => $request->user_id,
            ]);

            $covenantRecord = new GroupsCovenantRecored;
            $covenantRecord->delivery_type = 'driver';
            $covenantRecord->groups_covenant_id = $covenantItem->id;
            $covenantRecord->delivery_date = Carbon::now();
            $covenantRecord->delivery_by = $request->user_id;
            $covenantRecord->added_by = Auth::guard('admin')->user()->id;
            $covenantRecord->save();

            $request->session()->flash('status', 'تم تسليم العهد للسائق بنجاح');
        }
        return redirect()->route('my.groups.covenant.show', $group);
    }

    public function show_covanent_notes(Group $group, $id)
    {
        $covanent = GroupsCovenant::find($id);
        if ($covanent == null) {
            session()->flash('status', 'رقم العهدة غير صحيح');
            return back();
        }

        $recored = GroupsCovenantRecored::select(['id'])->where('groups_covenant_id', $covanent->id)->pluck('id')->toArray();
        $adding = GroupsCovenantRecored::where('groups_covenant_id', $covanent->id)->whereNull('receive_date')->whereNull('receive_by')->orderBy('id', 'desc')->first();

        if (count($recored) == 0) {
            session()->flash('status', 'لا يوجد مستلم لهذه العهدة');
            return back();

        }
        $notes = GroupsCovenantNotes::whereIn('groups_covenant_record_id', $recored)->with('added_by')->with('records')->get();
        // return $notes;
        return view('groups.myGroups.covanent.showCovanentNotes', compact('notes', 'group', 'id', 'adding'));

    }
    public function show_covanent_note_add(Group $group, $id)
    {

        return view('groups.myGroups.covanent.addNotesCovanent', compact('group', 'id'));
    }
    public function save_covanent_note(Group $group, Request $request)
    {
        $request->validate([
            'groups_covenant_record_id' => 'required|integer',
            'note_state' => "required|string",
            'subject' => "required|string",
            'content' => "required|string",
        ]);

        $note = new GroupsCovenantNotes;
        $note->groups_covenant_record_id = $request->groups_covenant_record_id;
        $note->note_state = $request->note_state;
        $note->subject = $request->subject;
        $note->description = $request->content;
        $note->add_date = Carbon::now();
        $note->add_by = Auth::guard('admin')->user()->id;
        $note->save();
        $request->session()->flash('status', 'تم حفظ ملاحظة بنجاح');
        $recored = GroupsCovenantRecored::where('id', $request->groups_covenant_record_id)->latest('id')->first();

        return redirect()->route('my.groups.covenant.show.notes', ['group' => $group, 'id' => $recored->groups_covenant_id]);

    }

}
