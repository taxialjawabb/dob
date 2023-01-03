<?php

namespace App\Http\Controllers\Admin\Nathiraat\Stakeholders\Notes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Nathiraat\StakeholdersNotes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Nathiraat\Stakeholders;
class NotesStakeholdersController extends Controller
{
    public function show_note($id)
    {
        $data = Stakeholders::find($id);
        if($data !== null){
            $notes = DB::select('select notes_nathriaat.id, note_type, content, add_date, 
                            attached, admins.name as admin_name from notes_nathriaat, admins 
                            where notes_nathriaat.admin_id = admins.id and nathriaat_id=?;', [$id]);
            return view('nathiraat.stakeholders.notes.showNotesStakeholders', compact('notes','id'));
        }else{
            return back();
        }
    }
    public function show_add($id)
    {
        $stakeholder = Stakeholders::find($id);
        if($stakeholder !== null){
            return  view('nathiraat.stakeholders.notes.addNotesStakeholders', compact('id'));
        }else{
            return back();
        }
    }
    public function add_note(Request $request)
    {
        $request->validate([            
            'nathriaat_id' =>     'required|integer',
            'notes_type' =>  'required|string',
            'content' =>        'required|string',
            //'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            
        ]);
        $stakeholder = Stakeholders::find($request->nathriaat_id);
        if($stakeholder !== null){
           $note = new StakeholdersNotes;
           $note->note_type = $request->notes_type;
           $note->content = $request->content;
           $note->add_date = Carbon::now();
           $note->admin_id = Auth::guard('admin')->user()->id;
           $note->nathriaat_id = $request->nathriaat_id;
            
            if($request->hasFile('image')){

                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/nathriaat/notes'),$image);
                
               $note->attached = $image;
            }
           $note->save();
            $request->session()->flash('status', 'تم اضافة ملاحظة لهذه الجهة');
            return redirect('nathiraat/stakeholders/notes/show/'.$request->nathriaat_id);
        }else{
            return back();
        }
    }
}
