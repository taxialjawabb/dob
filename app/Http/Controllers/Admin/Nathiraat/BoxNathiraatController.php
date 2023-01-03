<?php

namespace App\Http\Controllers\Admin\Nathiraat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Nathiraat\BoxNathriaat;
use Illuminate\Support\Facades\Auth;

class BoxNathiraatController extends Controller
{
    public function show_box($type)
    {
        if($type === 'spend' || $type === 'take'){
            $bonds = DB::select("
                        select boxd.id, stakeholders.name ,boxd.bond_type,boxd.payment_type,boxd.money,
                        boxd.tax,boxd.total_money,boxd.descrpition,boxd.add_date,admins.name as admin_name
                        from box_nathriaat as boxd left join   stakeholders on boxd.stakeholders_id= stakeholders.id
                        left join admins on boxd.add_by = admins.id 
                        where  boxd.bond_type = ?;
            ", [ $type]);
            $totalBond = DB::select('select bond_type, sum(total_money) as money  from box_nathriaat group by bond_type;');
            $take = 0;
            $spend = 0;
            if(count($totalBond)==2){
                $take = $totalBond[1]->money;
                $spend = $totalBond[0]->money;
            }
            else if(count($totalBond) == 1){
                if($totalBond[0]->bond_type == 'take'){
                    $take = $totalBond[0]->money;
                }
                else if($totalBond[0]->bond_type == 'spend'){
                    $spend = $totalBond[0]->money;
                }
            }
            return view('nathiraat.showBoxNathiraat', compact( 'bonds','type', 'take', 'spend'));
        }
        else{
            return back();
        }
        

    }
    public function show_add()
    {
        return  view('nathiraat.addBoxNathiraat');
    }

    public function add_box(Request $request)
    {
        $request->validate([            
            'bond_type' =>  'required|string|in:take,spend',
            'payment_type' =>        'required|string|in:cash,bank transfer,internal transfer,selling points,electronic payment',
            'money' =>          'required|numeric',
            'tax' =>        'required|numeric',
            'descrpition' =>        'required|string',
        ]);

            $totalMoney = $request->money + (($request->money * $request->tax) / 100);
            $boxNathiraat = new BoxNathriaat;
            $boxNathiraat->bond_type = $request->bond_type;
            $boxNathiraat->payment_type = $request->payment_type;
            $boxNathiraat->money = $request->money;
            $boxNathiraat->tax = $request->tax;
            $boxNathiraat->total_money = $totalMoney;
            $boxNathiraat->descrpition = $request->descrpition;
            $boxNathiraat->add_date = Carbon::now();
            $boxNathiraat->add_by = Auth::guard('admin')->user()->id;
            
            $boxNathiraat->save();
            $boxNathiraat->admin_name = Auth::guard('admin')->user()->name;
            
            $request->session()->flash('status', 'تم أضافة السند بنجاح');
            return view("nathiraat.confirmBillNathiraat", compact('boxNathiraat')); 
    }
}
