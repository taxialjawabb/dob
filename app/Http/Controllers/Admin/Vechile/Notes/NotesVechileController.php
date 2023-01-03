<?php

namespace App\Http\Controllers\Admin\Vechile\Notes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vechile;
use App\Models\Vechile\VechileNotes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotesVechileController extends Controller
{
    public function show_note($id)
    {
        $vechile = Vechile::find($id);
        if($vechile !== null){
            $notes = DB::select('select notes_vechile.id, note_type, content, add_date, attached, admins.name as admin_name from notes_vechile, admins where notes_vechile.admin_id = admins.id and vechile_id=?;', [$id]);
            return view('vechile.notes.showNotesVechile', compact('notes','vechile'));
        }else{
            return redirect('vechile/show');
        }
    }
    public function show_add($id)
    {
        $vechile = Vechile::find($id);
        if($vechile !== null){
            return  view('vechile.notes.addNotesVechile', compact('vechile'));
        }else{
            return redirect('vechile/show');
        }
    }
    public function add_note(Request $request)
    {
        $request->validate([            
            'vechile_id' =>     'required|integer',
            'note_type' =>  'required|string',
            'content' =>        'required|string',
            //'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            
        ]);
        $vechile = Vechile::find($request->vechile_id);
        if($vechile !== null){
            $note = new VechileNotes;
                $note->note_type = $request->note_type;
                $note->content = $request->content;
                $note->add_date = Carbon::now();
                $note->admin_id = Auth::guard('admin')->user()->id;
                $note->vechile_id = $request->vechile_id;

                if($request->hasFile('image')){                        
                    $file = $request->file('image');
                    $name = $file->getClientOriginalName();
                    $ext  = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    $mim  = $file->getMimeType();
                    $realpath = $file->getRealPath();
                    $image = time().'.'.$ext;
                    $file->move(public_path('images/vechiles/notes'),$image);
                    
                    $note->attached = $image;
                }
                $note->save();
                $request->session()->flash('status', 'تم اضافة مستند للمركبة');
                return redirect('vechile/notes/show/'.$request->vechile_id);
        }else{
            return redirect('vechile/show');
        }
    }
}