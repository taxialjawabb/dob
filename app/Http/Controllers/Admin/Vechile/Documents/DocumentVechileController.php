<?php

namespace App\Http\Controllers\Admin\Vechile\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vechile;
use App\Models\Vechile\VechileDocuments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DocumentVechileController extends Controller
{
    public function show_document($id)
    {
        $vechile = Vechile::find($id);
        if($vechile !== null){
            $documents = DB::select('select documents_vechile.id, document_type, content, add_date, attached, admins.name as admin_name from documents_vechile, admins where documents_vechile.admin_id = admins.id and vechile_id=?;', [$id]);
            return view('vechile.documents.showDocsVechile', compact('documents','vechile'));
        }else{
            return redirect('vechile/show');
        }
    }
    public function show_add($id)
    {
        $vechile = Vechile::find($id);
        if($vechile !== null){
            return  view('vechile.documents.addDocsVechile', compact('vechile'));
        }else{
            return redirect('vechile/show');
        }
    }
    public function add_document(Request $request)
    {
        $request->validate([            
            'vechile_id' =>     'required|integer',
            'document_type' =>  'required|string',
            'content' =>        'required|string',
            'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        ]);
        $vechile = Vechile::find($request->vechile_id);
        if($vechile !== null){

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
                $document->vechile_id = $request->vechile_id;
                $document->attached = $image;
                $document->save();
                $request->session()->flash('status', 'تم اضافة مستند للمركبة');
                return redirect('vechile/documents/show/'.$request->vechile_id);
            }
        }else{
            return redirect('vechile/show');
        }
    }
}
