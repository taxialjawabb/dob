<?php

namespace App\Http\Controllers\Admin\Groups\SharedGroups\Notes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Groups\Group;
use App\Models\Groups\GroupNotes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NotesControllers extends Controller
{
    public function note_show(Group $group)
    {
        if ($this->hasPermissionData($group->id) == false)
                   return back(); 
        return view('groups.shared.notes.addNotesDriver', compact('group'));
    }
    public function note_save(Request $request, Group $group)
    {
         if ($this->hasPermissionData($group->id) == false)
                     return back(); 
        $request->validate([
            'note_type' =>  'required|string',
            'content' =>        'required|string',
            'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        ]);

        $file = $request->file('image');
        $name = $file->getClientOriginalName();
        $ext  = $file->getClientOriginalExtension();
        $size = $file->getSize();
        $mim  = $file->getMimeType();
        $realpath = $file->getRealPath();
        $image = time().'.'.$ext;
        $file->move(public_path('images/groups/notes'),$image);

        GroupNotes::create([
            'note_type' => $request->note_type,
            'content' => $request->content,
            'add_date' => Carbon::now(),
            'added_by' => Auth::guard('admin')->user()->id,
            'group_id' => $group->id,
            'attached' => $image
        ]);

        $request->session()->flash('status', 'تم اضافة مستند للمجموعة');
        return redirect()->route('shared.groups.note.show', ['group' => $group]);
    }

    public function note_all_show(Group $group)
    {
        if ($this->hasPermissionData($group->id) == false)
                     return back(); 
        $notes = \DB::select('select notes_group.id, note_type, content, add_date, attached, admins.name as admin_name from notes_group left join admins on notes_group.added_by = admins.id  where group_id=?;', [$group->id]);

        return view('groups.shared.notes.showNotesDriver', compact('notes','group'));
    }
}
