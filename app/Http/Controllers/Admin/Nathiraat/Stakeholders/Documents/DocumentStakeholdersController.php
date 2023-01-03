<?php

namespace App\Http\Controllers\Admin\Nathiraat\Stakeholders\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nathiraat\StakeholdersDocuments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Nathiraat\Stakeholders;

class DocumentStakeholdersController extends Controller
{
    public function show_document($id)
    {

        $data = Stakeholders::find($id);
        if($data !== null){
            $documents = DB::select('select documents_nathriaat.id, document_type, content, add_date, attached, 
                                admins.name as admin_name from documents_nathriaat, admins 
                                where documents_nathriaat.admin_id = admins.id and nathriaat_id=?;', [$id]);
        return view('nathiraat.stakeholders.documents.showDocsStakeholders', compact('documents', 'id'));
        }else{
            return back();
        }
    }
    public function show_add($id)
    {
        $data = Stakeholders::find($id);
        if($data !== null){

            return  view('nathiraat.stakeholders.documents.addDocsStakeholders', compact('id'));
        }else{
            return back();
        }
    }
    public function add_document(Request $request)
    {
        $request->validate([            
            'nathriaat_id' =>     'required|integer',
            'document_type' =>  'required|string',
            'content' =>        'required|string',
            'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        ]);
        $stakeholder =  Stakeholders::find($request->nathriaat_id);
        if($stakeholder !== null){
            if($request->hasFile('image')){

                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/nathriaat/documents'),$image);
                $document = new StakeholdersDocuments;
                $document->document_type = $request->document_type;
                $document->content = $request->content;
                $document->add_date = Carbon::now();
                $document->admin_id = Auth::guard('admin')->user()->id;
                $document->nathriaat_id = $request->nathriaat_id;
                $document->attached = $image;
                $document->save();
                $request->session()->flash('status', 'تم اضافة مستند لهذه الجهة');
                return redirect('nathiraat/stakeholders/documents/show/'.$request->nathriaat_id);
            }
            return back();
        }else{
            return back();
        }
    }
}

