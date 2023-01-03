<?php

namespace App\Http\Controllers\Admin\Rider\Notes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rider;
use App\Models\Rider\RiderNotes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotesRiderController extends Controller
{
    public function show_note($id)
    {
        $rider = Rider::find($id);
        if($rider !== null){
            $notes = DB::select('select notes_rider.id, note_type, content, add_date, attached, admins.name as admin_name from notes_rider, admins where notes_rider.admin_id = admins.id and rider_id=?;', [$id]);
            return view('rider.notes.showNotesRider', compact('notes','rider'));
        }else{
            return redirect('rider/show');
        }
    }
    public function show_add($id)
    {
        $rider = Rider::find($id);
        if($rider !== null){
            return  view('rider.notes.addNotesRider', compact('rider'));
        }else{
            return redirect('rider/show');
        }
    }
    public function add_note(Request $request)
    {
        $request->validate([            
            'rider_id' =>     'required|integer',
            'note_type' =>  'required|string',
            'content' =>        'required|string',
           // 'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            
        ]);
        $rider = Rider::find($request->rider_id);
        if($rider !== null){
            $note = new RiderNotes;
                $note->note_type = $request->note_type;
                $note->content = $request->content;
                $note->add_date = Carbon::now();
                $note->admin_id = Auth::guard('admin')->user()->id;
                $note->rider_id = $request->rider_id;
                
            if($request->hasFile('image')){

                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/riders/notes'),$image);    
                $note->attached = $image;
            }
            $note->save();
            $request->session()->flash('status', 'تم اضافة مستند للسائق');
            return redirect('rider/notes/show/'.$request->rider_id);
        }else{
            return redirect('rider/show');
        }
    }
}
