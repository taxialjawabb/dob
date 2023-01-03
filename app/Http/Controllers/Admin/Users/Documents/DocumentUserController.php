<?php

namespace App\Http\Controllers\Admin\Users\Documents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User\UserDocuments;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DocumentUserController extends Controller
{
    public function show_document($id)
    {
        $user = Admin::find($id);
        if($user !== null){
            $documents = DB::select('select documents_user.id, document_type, content, add_date, attached, admins.name as admin_name from documents_user, admins where documents_user.admin_id = admins.id and user_id=?;', [$id]);
            return view('admin.users.documents.showDocsUser', compact('documents','user'));
        }else{
            return redirect('user/show');
        }
    }
    public function show_add($id)
    {
        $user = Admin::find($id);
        if($user !== null){
            return  view('admin.users.documents.addDocsUser', compact('user'));
        }else{
            return redirect('User/show');
        }
    }
    public function add_document(Request $request)
    {
        $request->validate([            
            'user_id' =>     'required|integer',
            'document_type' =>  'required|string',
            'content' =>        'required|string',
            'image' =>          'required|mimes:jpeg,png,jpg,gif,svg,pdf',
        ]);
        $user = Admin::find($request->user_id);
        if($user !== null){
            if($request->hasFile('image')){

                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/users/documents'),$image);
                $document = new UserDocuments;
                $document->document_type = $request->document_type;
                $document->content = $request->content;
                $document->add_date = Carbon::now();
                $document->admin_id = Auth::guard('admin')->user()->id;
                $document->user_id = $request->user_id;
                $document->attached = $image;
                $document->save();
                $request->session()->flash('status', 'تم اضافة مستند للسائق');
                return redirect('user/documents/show/'.$request->user_id);
            }
        }else{
            return redirect('user/show');
        }
    }
}

