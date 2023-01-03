<?php

namespace App\Http\Controllers\Admin\BankTransfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Rider\BankTransferRider;
use Illuminate\Support\Facades\Auth;
use App\Models\Rider;

class BankTransferClientController extends Controller
{
    public function show_request(Request $request)
    {
        $data = DB::select("
            select bank_transfer_rider.id,  bank_transfer_rider.person_name, bank_transfer_rider.bank_name,
            bank_transfer_rider.transfer_photo, money , bank_transfer_rider.created_at , rider.id as rider_id ,rider.name 
            from bank_transfer_rider , rider where bank_transfer_rider.rider_id = rider.id and bank_transfer_rider.state = 'pending';
        
        ");
        return view('bankTransfer.rider.show', compact('data'));
    }
    public function show_state($type)
    {
        if($type === 'refused' || $type === 'confimed'){

            $data = DB::select("
            select bank_transfer_rider.id, rider.name , bank_transfer_rider.person_name, bank_transfer_rider.bank_name,
            bank_transfer_rider.transfer_photo, money , bank_transfer_rider.created_at , admins.name as admin_name
            from bank_transfer_rider , rider, admins where bank_transfer_rider.rider_id = rider.id and bank_transfer_rider.admin_id = admins.id and bank_transfer_rider.state = ?;
            
            ", [$type]);
            return view('bankTransfer.rider.showAccptedAndRefused', compact('data', 'type'));
        }
        else{
            return back();
        }
    }

    public function refused_request($id)
    {
        $bankTransfer = BankTransferRider::find($id);
        if($bankTransfer !== null){
            $bankTransfer->state = 'refused';
            $bankTransfer->admin_id = Auth::guard('admin')->user()->id;
            $bankTransfer->save();
            return redirect('bank/transfer/rider/show');
        }
        else{
            return back();
        }
    }

    public function accept_request(Request $request)
    {
        $d =  $request->data;
        return view('bankTransfer.rider.confirm', compact('d'));
    }

    public function accept_save(Request $request)
    {
        $request->validate([            
            'rider_id' =>     'required|integer',
            'banktransfer_id' =>     'required|integer',
            'bond_type' =>  'required|string|in:take,spend',
            'payment_type' =>        'required|string|in:cash,bank transfer,internal transfer,selling points,electronic payment',
            'money' =>          'required|numeric',
            'tax' =>        'required|numeric',
            'descrpition' =>        'required|string',
        ]);
        $bankTransfer = BankTransferRider::find($request->banktransfer_id);
        $rider = Rider::find($request->rider_id);
        if($bankTransfer !== null && $rider !== null){
            $totalMoney =$request->money + (($request->money * $request->tax) / 100);
            $boxRider = new \App\Models\Rider\BoxRider;
            $boxRider->rider_id = $request->rider_id;
            $boxRider->bond_type = $request->bond_type;
            $boxRider->payment_type = $request->payment_type;
            $boxRider->money = $request->money;
            $boxRider->tax = $request->tax;
            $boxRider->total_money = $totalMoney;
            $boxRider->descrpition = $request->descrpition;
            $boxRider->add_date = \Carbon\Carbon::now();
            $boxRider->add_by = Auth::guard('admin')->user()->id;
            // if($request->bond_type === 'take'){
            //     $rider-> account = $rider-> account + $totalMoney;
            // }else if($request->bond_type === 'spend'){
            //     $rider-> account = $rider-> account - $totalMoney;
            // }
            $boxRider->save();
            // $rider->save();

            $bankTransfer->state = 'confimed';
            $bankTransfer->bond_id  = $boxRider->id;
            $bankTransfer->admin_id = Auth::guard('admin')->user()->id;
            $bankTransfer->save();

            $request->session()->flash('status', 'تم قبول التحويل البنكى بنجاح');
            return redirect("bank/transfer/rider/show");
        }else{
            $request->session()->flash('error', 'حدث خطاء اثناء قبول السند الرجاء محاولة فى وقت لاحق');
            return redirect('bank/transfer/rider/show');
        }
    }

}
