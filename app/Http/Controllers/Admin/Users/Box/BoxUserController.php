<?php

namespace App\Http\Controllers\Admin\Users\Box;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\User\BoxUser;
use Illuminate\Support\Facades\Auth;
use App\Traits\InternalTransfer;

class BoxUserController extends Controller
{
    use InternalTransfer;
    public function show_box($type , $id)
    {
        $user = Admin::find($id);
        if($user !== null){
            if($type === 'spend'){
                $bonds = DB::select("
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
                boxd.descrpition, bond_photo ,boxd.add_date, admins.name as admin_name
                from box_user as boxd , admins  where boxd.add_by=admins.id 
                and  user_id = ? and boxd.bond_type = 'spend';
                ", [$id]);
                return view('admin.users.box.showBoxUser', compact('user', 'bonds','type'));
            }
            else if($type === 'take'){
                $bonds = DB::select("
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
                boxd.descrpition,boxd.add_date, admins.name as admin_name
                from box_user as boxd , admins  where boxd.add_by=admins.id 
                and  user_id = ? and boxd.bond_type = 'take';
                ", [$id]);
                return view('admin.users.box.showBoxUser', compact('user', 'bonds','type'));
            }
            else{
                return back();
            }
        }else{
            return back();
        }        

    }
    public function show_add($id)
    {
        $user = Admin::find($id);
        if($user !== null){
            return  view('admin.users.box.addBoxUser', compact('user'));
        }else{
            return redirect('user/show');
        }
    }

    public function add_box(Request $request)
    {
        $request->validate([            
            'user_id' =>     'required|integer',
            'bond_type' =>  'required|string|in:take,spend',
            'payment_type' =>        'required|string|in:cash,bank transfer,internal transfer,selling points,electronic payment',
            'money' =>          'required|numeric',
            'tax' =>        'required|numeric',
            'descrpition' =>        'required|string',
        ]);
        if($request->bond_type === 'spend'){
            $request->validate([            
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf',
            ]);
        }

        if($request->has('stakeholder') && $request->payment_type === "internal transfer"){
            $request->validate([ 
                'stakeholder' =>'required|string|in:driver,vechile,rider,stakeholder,user',
                'user' => 'required|integer'
            ]); 
            $this->transfer($request);
        }
        $user = Admin::find($request->user_id);
        if($user !== null){
            $totalMoney =$request->money + (($request->money * $request->tax) / 100);
            $boxUser = new BoxUser;
            $boxUser->user_id = $request->user_id;
            $boxUser->bond_type = $request->bond_type;
            $boxUser->payment_type = $request->payment_type;
            $boxUser->money = $request->money;
            $boxUser->tax = $request->tax;
            $boxUser->total_money = $totalMoney;
            $boxUser->descrpition = $request->descrpition;
            $boxUser->add_date = Carbon::now();
            $boxUser->add_by = Auth::guard('admin')->user()->id;
            if($request->hasFile('image') && $request->image !== null){
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/bond/spend'),$image);
                $boxUser->bond_photo = $image;
            }
            // if($request->bond_type === 'take'){
            //     $user-> account = $user-> account + $totalMoney;
            // }else if($request->bond_type === 'spend'){
            //     $user-> account = $user-> account - $totalMoney;
            // }
            $boxUser->save();
            // $user->save();
            
            $request->session()->flash('status', 'تم أضافة السند بنجاح');
            return redirect("user/box/show/".$request->bond_type ."/". $user->id);
        }else{
            return redirect('user/show');
        }

    }
}
