<?php

namespace App\Http\Controllers\Admin\BankTransfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Driver\BankTransferDriver;
use Illuminate\Support\Facades\Auth;
use App\Models\Driver;

class BankTransferDriverController extends Controller
{
    public function show_request(Request $request)
    {
        $data = DB::select("
            select bank_transfer_driver.id,  bank_transfer_driver.person_name, bank_transfer_driver.bank_name,
            bank_transfer_driver.transfer_photo, money , bank_transfer_driver.created_at , driver.id as driver_id ,driver.name 
            from bank_transfer_driver , driver where bank_transfer_driver.driver_id = driver.id and bank_transfer_driver.state = 'pending';
        
        ");
        return view('bankTransfer.driver.show', compact('data'));
    }
    public function show_state($type)
    {
        if($type === 'refused' || $type === 'confimed'){

            $data = DB::select("
            select bank_transfer_driver.id, driver.name , bank_transfer_driver.person_name, bank_transfer_driver.bank_name,
            bank_transfer_driver.transfer_photo, money , bank_transfer_driver.created_at , admins.name as admin_name
            from bank_transfer_driver , driver, admins where bank_transfer_driver.driver_id = driver.id and bank_transfer_driver.admin_id = admins.id and bank_transfer_driver.state = ?;
            
            ", [$type]);
            return view('bankTransfer.driver.showAccptedAndRefused', compact('data', 'type'));
        }
        else{
            return back();
        }
    }

    public function refused_request($id)
    {
        $bankTransfer = BankTransferDriver::find($id);
        if($bankTransfer !== null){
            $bankTransfer->state = 'refused';
            $bankTransfer->admin_id = Auth::guard('admin')->user()->id;
            $bankTransfer->save();
            return redirect('bank/transfer/driver/show');
        }
        else{
            return back();
        }
    }

    public function accept_request(Request $request)
    {
        $d =  $request->data;
        return view('bankTransfer.driver.confirm', compact('d'));
    }

    public function accept_save(Request $request)
    {
        $request->validate([            
            'driver_id' =>     'required|integer',
            'banktransfer_id' =>     'required|integer',
            'bond_type' =>  'required|string|in:take,spend',
            'payment_type' =>        'required|string|in:cash,bank transfer,internal transfer,selling points,electronic payment',
            'money' =>          'required|numeric',
            'tax' =>        'required|numeric',
            'descrpition' =>        'required|string',
        ]);
        $bankTransfer = BankTransferDriver::find($request->banktransfer_id);
        $driver = Driver::find($request->driver_id);
        if($bankTransfer !== null && $driver !== null){
            $totalMoney =$request->money + (($request->money * $request->tax) / 100);
            $boxDriver = new \App\Models\Driver\BoxDriver;
            $boxDriver->driver_id = $request->driver_id;
            $boxDriver->bond_type = $request->bond_type;
            $boxDriver->payment_type = $request->payment_type;
            $boxDriver->money = $request->money;
            $boxDriver->tax = $request->tax;
            $boxDriver->total_money = $totalMoney;
            $boxDriver->descrpition = $request->descrpition;
            $boxDriver->add_date = \Carbon\Carbon::now();
            $boxDriver->add_by = Auth::guard('admin')->user()->id;
            // if($request->bond_type === 'take'){
            //     $driver-> account = $driver-> account + $totalMoney;
            // }else if($request->bond_type === 'spend'){
            //     $driver-> account = $driver-> account - $totalMoney;
            // }
            $boxDriver->save();
            // $driver->save();

            $bankTransfer->state = 'confimed';
            $bankTransfer->bond_id  = $boxDriver->id;
            $bankTransfer->admin_id = Auth::guard('admin')->user()->id;
            $bankTransfer->save();

            $request->session()->flash('status', 'تم قبول التحويل البنكى بنجاح');
            return redirect("bank/transfer/driver/show");
        }else{
            $request->session()->flash('error', 'حدث خطاء اثناء قبول السند الرجاء محاولة فى وقت لاحق');
            return redirect('bank/transfer/driver/show');
        }
    }

}
