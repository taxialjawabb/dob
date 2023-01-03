<?php

namespace App\Http\Controllers\Admin\Vechile\Box;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Vechile;
use App\Models\Vechile\BoxVechile;
use Illuminate\Support\Facades\Auth;
use App\Traits\InternalTransfer;

class BoxVechileController extends Controller
{
    use InternalTransfer;
    public function show_box($type , $id)
    {
        if($type === 'spend' || $type === 'take'){
            $vechile = Vechile::find($id);
            if($vechile !== null){
                $bonds = DB::select("
                select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition, bond_photo ,boxd.add_date,admins.name as admin_name
                from box_vechile as boxd left join admins on boxd.add_by= admins.id  where   boxd.vechile_id = ? and boxd.bond_type = ?;
                ", [$id, $type]);
                return view('vechile.box.showBoxVechile', compact('vechile', 'bonds','type'));
            }else{
                return redirect('vechile/show');
            }
        }
        else{
            return back();
        }
        

    }
    public function show_add($id)
    {
        $vechile = Vechile::find($id);
        if($vechile !== null){
            return  view('vechile.box.addBoxVechile', compact('vechile'));
        }else{
            return redirect('vechile/show');
        }
    }

    public function add_box(Request $request)
    {
        $request->validate([            
            'vechile_id' =>     'required|integer',
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
        $vechile = Vechile::find($request->vechile_id);
        if($vechile !== null){
            $totalMoney = $request->money + (($request->money * $request->tax) / 100);
            $boxVechile = new BoxVechile;
            $boxVechile->vechile_id = $request->vechile_id;
            $boxVechile->bond_type = $request->bond_type;
            $boxVechile->payment_type = $request->payment_type;
            $boxVechile->money = $request->money;
            $boxVechile->tax = $request->tax;
            $boxVechile->total_money = $totalMoney;
            $boxVechile->descrpition = $request->descrpition;
            $boxVechile->add_date = Carbon::now();
            $boxVechile->add_by = Auth::guard('admin')->user()->id;
            if($request->hasFile('image') && $request->image !== null){
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/bond/spend'),$image);
                $boxVechile->bond_photo = $image;
            }
            // if($request->bond_type === 'take'){
            //     $vechile-> account = $vechile-> account + $totalMoney;
            // }else if($request->bond_type === 'spend'){
            //     $vechile-> account = $vechile-> account - $totalMoney;
            // }

            $boxVechile->save();
            // $vechile->save();

            $request->session()->flash('status', 'تم أضافة السند بنجاح');
            return redirect("vechile/box/show/".$request->bond_type ."/". $vechile->id);
            
        }else{
            return redirect('vechile/show');
        }

    }
}
