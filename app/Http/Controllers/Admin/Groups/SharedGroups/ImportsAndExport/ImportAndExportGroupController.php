<?php

namespace App\Http\Controllers\Admin\Groups\SharedGroups\ImportsAndExport;

use App\Http\Controllers\Controller;
use App\Models\Groups\Group;
use App\Models\Groups\GroupImportExport;
use Auth;
use Illuminate\Http\Request;

class ImportAndExportGroupController extends Controller
{
    public function show($type,$id)
    {
        if ($this->hasPermissionData($id) == false)
                return back(); 
        if($type === 'import' || $type === 'export'){
            $data  = GroupImportExport::select(['id', 'title', 'content', 'type', 'add_date', 'attached'])
            ->where('type' , $type)
            ->where('group_id' , $id)->get();
            $group = Group::find($id);
            return view('groups.shared.importAndExport.showImportAndExport' , compact('data', 'type','id','group'));
        }
        else{
            return back();
        }
    }

    public function add($id)
    {
        $group = Group::find($id);
        return view('groups.shared.importAndExport.addImportAndExport' , compact('id','group'));
    }
    public function add_save(Request $request)
    {
        $request->validate([
            "stackholder" => "required|string",
            "type" => "required|string|in:import,export",
            "title" => "required|string",
            "content" => "required|string",
            'group_id'=>"required|string"
        ]);



        if ($this->hasPermissionData($request->group_id) == false)
                  return back();
            $importsAndExport = new GroupImportExport;
            $importsAndExport->type = $request->type;
            $importsAndExport->title = $request->title;
            $importsAndExport->content = $request->content;
            $importsAndExport->group_id = $request->group_id;
            $importsAndExport->add_date = \Carbon\Carbon::now();
            $importsAndExport->added_by = Auth::guard('admin')->user()->id;
            $importsAndExport->stackholder = $request->stackholder;

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
            $request->session()->flash('status', 'تم اضافة '.$text.' هذه الجهة  ' . $request->stackholder);
            return redirect('shared/groups/importandexport/show/'.$request->type.'/'. $request->group_id);

    }
}
