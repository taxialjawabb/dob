<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\Driver\DriverDocuments;
use App\Models\Nathiraat\Stakeholders;
use App\Models\Nathiraat\StakeholdersDocuments;
use App\Models\Rider;
use App\Models\Rider\RiderDocuments;
use App\Models\User\UserDocuments;
use App\Models\Vechile\VechileDocuments;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DocumentsController extends Controller
{
    public function show_add_document()
    {
        return view('general/add_document');
    }
    public function save_document(Request $request)
    {
        $request->validate([
            "stakeholder" => 'required|string',
            "user" => 'required|string',
            "content" => 'required|string',
            "document_type" => 'required|string',
            'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        ]);
        if($request->stakeholder=='driver')
        {
            $note_to=Driver::find($request->user);
            if($note_to!=null)
            {
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $name = $file->getClientOriginalName();
                    $ext  = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    $mim  = $file->getMimeType();
                    $realpath = $file->getRealPath();
                    $image = time().'.'.$ext;
                    $file->move(public_path('images/drivers/documents'), $image);
                    $document = new DriverDocuments();
                    $document->document_type = $request->document_type;
                    $document->content = $request->content;
                    $document->add_date = Carbon::now();
                    $document->admin_id = Auth::guard('admin')->user()->id;
                    $document->driver_id = $request->user;
                    $document->attached = $image;
                    $document->save();
                    $request->session()->flash('status', 'تم اضافة مستند للسائق');
                }
            }
        }
        if($request->stakeholder=='vechile')
        {

            $note_to=\App\Models\Vechile::find($request->user);
                    if ($note_to!=null)
                    {
                        if($request->hasFile('image')){
                            // return dd($request->all());
                            $file = $request->file('image');
                            $name = $file->getClientOriginalName();
                            $ext  = $file->getClientOriginalExtension();
                            $size = $file->getSize();
                            $mim  = $file->getMimeType();
                            $realpath = $file->getRealPath();
                            $image = time().'.'.$ext;
                            $file->move(public_path('images/vechiles/documents'),$image);
                            $document = new VechileDocuments;
                            $document->document_type = $request->document_type;
                            $document->content = $request->content;
                            $document->add_date = Carbon::now();
                            $document->admin_id = Auth::guard('admin')->user()->id;
                            $document->vechile_id = $request->user;
                            $document->attached = $image;
                            $document->save();
                            $request->session()->flash('status', 'تم اضافة مستند للمركبة');
                    }
               
            }
        }
        if($request->stakeholder=='rider')
        {
            $note_to=Rider::find($request->user);
            if ($note_to!=null) 
            {
            
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $name = $file->getClientOriginalName();
                    $ext  = $file->getClientOriginalExtension();
                    $size = $file->getSize();
                    $mim  = $file->getMimeType();
                    $realpath = $file->getRealPath();
                    $image = time().'.'.$ext;
                    $file->move(public_path('images/riders/documents'), $image);
                    $document = new RiderDocuments();
                    $document->document_type = $request->document_type;
                    $document->content = $request->content;
                    $document->add_date = Carbon::now();
                    $document->admin_id = Auth::guard('admin')->user()->id;
                    $document->rider_id = $request->user;
                    $document->attached = $image;
                    $document->save();
                    $request->session()->flash('status', 'تم اضافة مستند للعميل');
                }
                
            }

        }
        if($request->stakeholder=='user')
        {
            $note_to=Admin::find($request->user);
            if ($note_to!=null) 
            {
                
                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $name = $file->getClientOriginalName();
                        $ext  = $file->getClientOriginalExtension();
                        $size = $file->getSize();
                        $mim  = $file->getMimeType();
                        $realpath = $file->getRealPath();
                        $image = time().'.'.$ext;
                        $file->move(public_path('images/users/documents'), $image);
                        $document = new UserDocuments();
                        $document->document_type = $request->document_type;
                        $document->content = $request->content;
                        $document->add_date = Carbon::now();
                        $document->admin_id = Auth::guard('admin')->user()->id;
                        $document->user_id = $request->user;
                        $document->attached = $image;
                        $document->save();
                        $request->session()->flash('status', 'تم اضافة مستند للمستخدم');
                    }
                
            }
        }
        if($request->stakeholder=='stakeholder')
        {
            $note_to=Stakeholders::find($request->user);
            if ($note_to!=null) 
            {
               

                    if ($request->hasFile('image')) {
                        $file = $request->file('image');
                        $name = $file->getClientOriginalName();
                        $ext  = $file->getClientOriginalExtension();
                        $size = $file->getSize();
                        $mim  = $file->getMimeType();
                        $realpath = $file->getRealPath();
                        $image = time().'.'.$ext;
                        $file->move(public_path('images/nathriaat/documents'), $image);
                        $document = new StakeholdersDocuments;
                        $document->document_type = $request->document_type;
                        $document->content = $request->content;
                        $document->add_date = Carbon::now();
                        $document->admin_id = Auth::guard('admin')->user()->id;
                        $document->nathriaat_id = $request->user;
                        $document->attached = $image;
                        $document->save();
                        $request->session()->flash('status', 'تم اضافة مستند لهذه الجهة');
                    }
            }

        }
        return back();
    }
}
