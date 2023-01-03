<?php

namespace App\Http\Controllers\Admin\Nathiraat\Stakeholders\Box;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Nathiraat\Stakeholders;
use App\Models\Nathiraat\BoxNathriaat;
use App\Traits\InternalTransfer;

class BoxStakeholdersController extends Controller
{
    use InternalTransfer;
    public function show_box($type , $id)
    {
        $stakeholder = Stakeholders::find($id);
        if($stakeholder !== null){
            if($type === 'spend'){
                $bonds = DB::select("
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
                boxd.descrpition, bond_photo ,boxd.add_date,admins.name as admin_name
                from box_nathriaat as boxd left join   stakeholders  on boxd.stakeholders_id = stakeholders.id 
                left join  admins on  boxd.add_by = admins.id  where 
                stakeholders.id = ?  and boxd.bond_type = 'spend' 
                union
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition, bond_photo ,boxd.add_date , '' as admin_name
                from box_driver as boxd  where ( boxd.foreign_type='stakeholders' and boxd.foreign_id = ? and boxd.bond_type = 'take') 
                union 
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition, bond_photo ,boxd.add_date , '' as admin_name
                from box_vechile as boxd  where ( boxd.foreign_type='stakeholders' and boxd.foreign_id = ? and boxd.bond_type = 'take') ;
                ", [$id , $id, $id]);
                return view('nathiraat.stakeholders.box.showBoxStakeholders', compact('stakeholder', 'bonds','type'));
            }
            else if($type === 'take'){
                $bonds = DB::select("
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,
                boxd.descrpition,boxd.add_date,admins.name as admin_name
                from box_nathriaat as boxd left join   stakeholders  on boxd.stakeholders_id = stakeholders.id 
                left join  admins on  boxd.add_by = admins.id  where 
                stakeholders.id = ? and boxd.bond_type = 'take' 
                union
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date , '' as admin_name
                from box_driver as boxd  where ( boxd.foreign_type='stakeholders' and boxd.foreign_id = ? and boxd.bond_type = 'spend') 
                union
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date , '' as admin_name
                from box_vechile as boxd  where ( boxd.foreign_type='stakeholders' and boxd.foreign_id = ? and boxd.bond_type = 'spend') ;
                ", [$id, $id, $id]);
                return view('nathiraat.stakeholders.box.showBoxStakeholders', compact('stakeholder', 'bonds','type'));
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
        $stakeholder = Stakeholders::find($id);
        if($stakeholder !== null){
            return  view('nathiraat.stakeholders.box.addBoxStakeholders', compact('id'));
        }else{
            return back();
        }
    }

    public function add_box(Request $request)
    {
        $request->validate([            
            'stakeholders_id' =>     'required|integer',
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
        $stakeholder = Stakeholders::find($request->stakeholders_id);
        if($stakeholder !== null){
            $totalMoney =$request->money + (($request->money * $request->tax) / 100);
            $boxNathriaat = new BoxNathriaat;
            $boxNathriaat->stakeholders_id = $request->stakeholders_id;
            $boxNathriaat->bond_type = $request->bond_type;
            $boxNathriaat->payment_type = $request->payment_type;
            $boxNathriaat->money = $request->money;
            $boxNathriaat->tax = $request->tax;
            $boxNathriaat->total_money = $totalMoney;
            $boxNathriaat->descrpition = $request->descrpition;
            $boxNathriaat->add_date = Carbon::now();
            $boxNathriaat->add_by = Auth::guard('admin')->user()->id;
            if($request->hasFile('image') && $request->image !== null){
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/bond/spend'),$image);
                $boxNathriaat->bond_photo = $image;
            }
            // if($request->bond_type === 'take'){
            //     $stakeholder-> account = $stakeholder-> account + $totalMoney;
            // }else if($request->bond_type === 'spend'){
            //     $stakeholder-> account = $stakeholder-> account - $totalMoney;
            // }
            $boxNathriaat->save();
            // $stakeholder->save();
            
            $request->session()->flash('status', 'تم أضافة السند بنجاح');
            return redirect("nathiraat/stakeholders/box/show/".$request->bond_type ."/". $stakeholder->id);
        }else{
            return back();
        }

    }
}
