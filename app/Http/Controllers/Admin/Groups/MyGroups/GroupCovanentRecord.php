<?php

namespace App\Http\Controllers\Admin\Groups\MyGroups;

use App\Http\Controllers\Controller;
use App\Models\Groups\Covenants\GroupsCovenantRecored;
use App\Models\Groups\Group;
use Illuminate\Http\Request;

class GroupCovanentRecord extends Controller
{

    public function show_history(Group $group,$id)
    {

        if ($this->hasPermissionData($group->id) == false) {
            return back();
        }
        $data = GroupsCovenantRecored::where('groups_covenant_id',$id)->get();
        return view('groups.myGroups.covanent.showCovenantRecord',compact('data','group'));

    }
}
