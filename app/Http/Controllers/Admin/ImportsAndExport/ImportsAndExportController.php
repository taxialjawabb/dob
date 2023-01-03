<?php

namespace App\Http\Controllers\Admin\ImportsAndExport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImportsAndExport;
use App\Models\Nathiraat\Stakeholders;
use Illuminate\Support\Facades\Auth;

class ImportsAndExportController extends Controller
{
    public function show($type)
    {
        if($type === 'import' || $type === 'export'){
            $data  = ImportsAndExport::select(['id', 'title', 'content', 'type', 'add_date', 'stakeholder_id', 'attached'])
            ->where('type' , $type)
            ->with('stakeholder:id,name')->get();
            return view('importAndExport/showImportAndExport' , compact('data', 'type'));
        }
        else{
            return back();
        }
    }

    public function add()
    {
        $stakeholders = Stakeholders::select(['id', 'name'])->get();
        return view('importAndExport/addImportAndExport' , compact('stakeholders'));
    }
    public function add_save(Request $request)
    {
        $request->validate([            
            "stakeholder_id" => "required|integer",
            "type" => "required|string|in:import,export",
            "title" => "required|string",
            "content" => "required|string"
        ]);

        $stakeholder = Stakeholders::find($request->stakeholder_id);

        if($stakeholder !== null){
            $importsAndExport = new ImportsAndExport;
            $importsAndExport->type = $request->type;
            $importsAndExport->title = $request->title;
            $importsAndExport->content = $request->content;
            $importsAndExport->add_date = \Carbon\Carbon::now();
            $importsAndExport->added_by = Auth::guard('admin')->user()->id;
            $importsAndExport->stakeholder_id = $request->stakeholder_id;
            
            if($request->hasFile('image')){

                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/importsAndExport'),$image);
                
               $importsAndExport->attached = $image;
            }
           $importsAndExport->save();
           $text = $request->type == 'import' ? 'وارد من': 'صادر إلى' ;
            $request->session()->flash('status', 'تم اضافة '.$text.' هذه الجهة  ' . $stakeholder->name);
            return redirect('import/export/show/'. $request->type);
        }else{
            return back();
        }
    }
}
