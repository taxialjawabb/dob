<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\Driver\DriverNotes;
use App\Models\Nathiraat\Stakeholders;
use App\Models\Nathiraat\StakeholdersNotes;
use App\Models\Rider;
use App\Models\User;
use App\Models\User\UserNotes;
use App\Models\Vechile;
use App\Models\Vechile\VechileNotes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotesController extends Controller
{
    public function show_add_note()
    {
        return view('general/add_note');
    }
    public function save_note(Request $request)
    {
       
        $request->validate([
            "stakeholder" => 'required|string',
            "user" => 'required|string',
            "content" => 'required|string',
            "notes_type" => 'required|string',
        ]);
        if($request->stakeholder=='driver')
        {
            $note_to=Driver::find($request->user);
            if($note_to!=null)
            {
                $note = new DriverNotes;
                $note->note_type = $request->notes_type;
                $note->content = $request->content;
                $note->add_date = Carbon::now();
                $note->admin_id = Auth::guard('admin')->user()->id;
                $note->driver_id = $request->user;
                 
                 if($request->hasFile('image')){
     
                     $file = $request->file('image');
                     $name = $file->getClientOriginalName();
                     $ext  = $file->getClientOriginalExtension();
                     $size = $file->getSize();
                     $mim  = $file->getMimeType();
                     $realpath = $file->getRealPath();
                     $image = time().'.'.$ext;
                     $file->move(public_path('images/drivers/notes'),$image);
                     
                    $note->attached = $image;
                 }
                 $note->save();
                 $request->session()->flash('status', 'تم اضافة ملاحظة للسائق');
               
            }
        }
        if($request->stakeholder=='vechile')
        {

            $note_to=Vechile::find($request->user);
            if ($note_to!=null) {
                $note = new VechileNotes();
                $note->note_type = $request->note_type;
                $note->content = $request->content;
                $note->add_date = Carbon::now();
                $note->admin_id = Auth::guard('admin')->user()->id;
                $note->vechile_id = $request->user;

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $name = $file->getClientOriginalName();
                    $ext  = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    $mim  = $file->getMimeType();
                    $realpath = $file->getRealPath();
                    $image = time().'.'.$ext;
                    $file->move(public_path('images/vechiles/notes'), $image);

                    $note->attached = $image;
                }
                $note->save();
                $request->session()->flash('status', 'تم اضافة مستند للمركبة');
            }
        }
        if($request->stakeholder=='rider')
        {
            $note_to=Rider::find($request->user);
            if ($note_to!=null) 
            {
                $note = new \App\Models\Rider\RiderNotes;
                $note->note_type = $request->note_type;
                $note->content = $request->content;
                $note->add_date = Carbon::now();
                $note->admin_id = Auth::guard('admin')->user()->id;
                $note->rider_id = $request->user;
                
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
            $request->session()->flash('status', 'تم اضافة مستند للعميل');
                
            }

        }
        if($request->stakeholder=='user')
        {
            $note_to=Admin::find($request->user);
            if ($note_to!=null) 
            {
                $note = new UserNotes;
                $note->note_type = $request->notes_type;
                $note->content = $request->content;
                $note->add_date = Carbon::now();
                $note->admin_id = Auth::guard('admin')->user()->id;
                $note->user_id = $request->user;
                 
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
                 $request->session()->flash('status', 'تم اضافة ملاحظة لمستخدم');
                
            }
        }
        if($request->stakeholder=='stakeholder')
        {
            $note_to=Stakeholders::find($request->user);
            if ($note_to!=null) 
            {
                $note = new StakeholdersNotes;
                $note->note_type = $request->notes_type;
                $note->content = $request->content;
                $note->add_date = Carbon::now();
                $note->admin_id = Auth::guard('admin')->user()->id;
                $note->nathriaat_id = $request->user;
                 
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
                
            }

        }
        return back();
    }
    
    
    //
}
