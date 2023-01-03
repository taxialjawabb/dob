<?php

namespace App\Http\Controllers\Admin\Rider\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rider;
use App\Models\Rider\RiderDocuments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DocumentRiderController extends Controller
{
    public function show_document($id)
    {
        $rider = Rider::find($id);
        if($rider !== null){
            $documents = DB::select('select documents_rider.id, document_type, content, add_date, attached, admins.name as admin_name from documents_rider, admins where documents_rider.admin_id = admins.id and rider_id=?;', [$id]);
            return view('rider.documents.showDocsRider', compact('documents','rider'));
        }else{
            return redirect('rider/show');
        }
    }
    public function show_add($id)
    {
        $rider = Rider::find($id);
        if($rider !== null){
            return  view('rider.documents.addDocsRider', compact('rider'));
        }else{
            return redirect('rider/show');
        }
    }
    public function add_document(Request $request)
    {
        $request->validate([            
            'rider_id' =>     'required|integer',
            'document_type' =>  'required|string',
            'content' =>        'required|string',
            'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        ]);
        $rider = Rider::find($request->rider_id);
        if($rider !== null){
            if($request->hasFile('image')){

                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/riders/documents'),$image);
                $document = new RiderDocuments;
                $document->document_type = $request->document_type;
                $document->content = $request->content;
                $document->add_date = Carbon::now();
                $document->admin_id = Auth::guard('admin')->user()->id;
                $document->rider_id = $request->rider_id;
                $document->attached = $image;
                $document->save();
                $request->session()->flash('status', 'تم اضافة مستند للسائق');
                return redirect('rider/documents/show/'.$request->rider_id);
            }
        }else{
            return redirect('rider/show');
        }
    }
}
