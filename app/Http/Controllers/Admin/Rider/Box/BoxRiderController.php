<?php

namespace App\Http\Controllers\Admin\Rider\Box;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Rider;
use App\Models\Rider\BoxRider;
use Illuminate\Support\Facades\Auth;
use App\Traits\InternalTransfer;

class BoxRiderController extends Controller
{
    use InternalTransfer;
    public function show_box($type , $id)
    {
        if($type === 'spend' || $type === 'take'){
            $rider = Rider::find($id);
            if($rider !== null){
                if($type === 'spend'){
                    $bonds = DB::select("
                    select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition, bond_photo ,boxd.add_date, admins.name as admin_name
                    from box_rider as boxd left join admins on boxd.add_by=admins.id  where  rider_id = ? and boxd.bond_type = 'spend'
                    union
                    select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition, bond_photo ,boxd.add_date , '' as admin_name
                    from box_vechile as boxd  where ( boxd.foreign_type='rider' and boxd.foreign_id = ? and boxd.bond_type = 'take') ;
                    ", [$id, $type]);
                    return view('rider.box.showBoxRider', compact('rider', 'bonds','type'));
                }else if($type === 'take'){
                    $bonds = DB::select("
                    select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date, admins.name as admin_name
                    from box_rider as boxd left join admins on boxd.add_by=admins.id  where  rider_id = ? and boxd.bond_type = 'take'
                    union
                    select boxd.id,boxd.bond_type,boxd.payment_type,boxd.money,boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date , '' as admin_name
                    from box_vechile as boxd  where ( boxd.foreign_type='rider' and boxd.foreign_id = ? and boxd.bond_type = 'spend') ;
                    ", [$id, $type]);
                    return view('rider.box.showBoxRider', compact('rider', 'bonds','type'));
                }
            }else{
                return redirect('rider/show');
            }
        }
        else{
            return back();
        }


    }
    public function show_add($id)
    {
        $rider = Rider::find($id);
        if($rider !== null){
            return  view('rider.box.addBoxRider', compact('rider'));
        }else{
            return redirect('rider/show');
        }
    }

    public function add_box(Request $request)
    {
        $request->validate([
            'rider_id' =>     'required|integer',
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
        $rider = Rider::find($request->rider_id);
        if($rider !== null){
            $totalMoney =$request->money + (($request->money * $request->tax) / 100);
            $BoxRider = new BoxRider;
            $BoxRider->rider_id = $request->rider_id;
            $BoxRider->bond_type = $request->bond_type;
            $BoxRider->payment_type = $request->payment_type;
            $BoxRider->money = $request->money;
            $BoxRider->tax = $request->tax;
            $BoxRider->total_money = $totalMoney;
            $BoxRider->descrpition = $request->descrpition;
            $BoxRider->add_date = Carbon::now();
            $BoxRider->add_by = Auth::guard('admin')->user()->id;
            if($request->hasFile('image') && $request->image !== null){
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/bond/spend'),$image);
                $BoxRider->bond_photo = $image;
            }
            // if($request->bond_type === 'take'){
            //     $rider-> account = $rider-> account + $totalMoney;
            // }else if($request->bond_type === 'spend'){
            //     $rider-> account = $rider-> account - $totalMoney;
            // }
            $BoxRider->save();
            // $rider->save();



            $request->session()->flash('status', 'تم أضافة السند بنجاح');
            return redirect("rider/box/show/".$request->bond_type ."/". $rider->id);
        }else{
            return redirect('rider/show');
        }

    }
}
