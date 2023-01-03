<?php

namespace App\Http\Controllers\Admin\Users\Notes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User\UserNotes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class NotesUserController extends Controller
{
    public function show_note($id)
    {
        $user = Admin::find($id);
        if($user !== null){
            $notes = DB::select('select notes_user.id, note_type, content, add_date, attached, admins.name as admin_name from notes_user, admins where notes_user.admin_id = admins.id and user_id=?;', [$id]);
            return view('admin.users.notes.showNotesUser', compact('notes','user'));
        }else{
            return redirect('user/show');
        }
    }
    public function show_add($id)
    {
        $user = Admin::find($id);
        if($user !== null){
            return  view('admin.users.notes.addNotesUser', compact('user'));
        }else{
            return redirect('user/show');
        }
    }
    public function add_note(Request $request)
    {
        $request->validate([            
            'user_id' =>     'required|integer',
            'notes_type' =>  'required|string',
            'content' =>        'required|string',
            //'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            
        ]);
        $user = Admin::find($request->user_id);
        if($user !== null){
           $note = new UserNotes;
           $note->note_type = $request->notes_type;
           $note->content = $request->content;
           $note->add_date = Carbon::now();
           $note->admin_id = Auth::guard('admin')->user()->id;
           $note->user_id = $request->user_id;
            
            if($request->hasFile('image')){

                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/users/notes'),$image);
                
               $note->attached = $image;
            }
           $note->save();
            $request->session()->flash('status', 'تم اضافة ملاحظة للسائق');
            return redirect('user/notes/show/'.$request->user_id);
        }else{
            return redirect('user/show');
        }
    }
}
