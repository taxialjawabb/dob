<?php

namespace App\Http\Controllers\Api\Transfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;


class TransferBankController extends Controller
{
    use GeneralTrait;
    public function transfer_bank_rider(Request $request)
    {
        $request->validate([
            'rider_id'   => 'required|string',
            'bank_name'    => 'required|string',
            'person_name'    => 'required|string',
            'money'   => 'required|string',
            'transfer_photo'=> 'required|mimes:jpeg,png,jpg,gif,svg',       
            
        ]);
        
        $rider = \App\Models\Rider::find($request->rider_id);
        if($rider == null){
            return $this->returnError('E001',"حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
        else
        {
            $image="";
            if($request->hasFile('transfer_photo')){
     
                $file = $request->file('transfer_photo');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/riders/banktransfer'),$image);

            }
            $bankTransfer = \App\Models\Rider\BankTransferRider::create([
                'rider_id' => $request->rider_id,
                'bank_name' => $request->bank_name,
                'person_name'=> $request->person_name ,
                'money'   => $request->money,
                'state' => 'pending',
                'transfer_photo'   => $image,
                
            ]);
            return $this -> returnData('data' , $bankTransfer, 'add transfer successfully watting for review');  
        }
    }

    public function show(Request $request)
    {
        $request->validate([
            'rider_id'   => 'required|string'            
        ]);
        $data = \App\Models\Rider\BankTransferRider::where('rider_id', $request->rider_id)->paginate(10);;
        return $this -> returnData('data' , $data, 'request for bank transfer add balance');  

    }
    public function transfer_bank_driver(Request $request)
    {
        $request->validate([
            'driver_id'   => 'required|string',
            'bank_name'    => 'required|string',
            'person_name'    => 'required|string',
            'money'   => 'required|string',
            'transfer_photo'=> 'required|mimes:jpeg,png,jpg,gif,svg',       
            
        ]);
        $driver = \App\Models\Driver::find($request->driver_id);
        if($driver == null){
            return $this->returnError('E001',"حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
        else
        {
            $image="";
            if($request->hasFile('transfer_photo')){
     
                $file = $request->file('transfer_photo');
                $name = $file->getClientOriginalName();
                $ext  = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim  = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time().'.'.$ext;
                $file->move(public_path('images/drivers/banktransfer'),$image);

            }
            $bankTransfer = \App\Models\Driver\BankTransferDriver::create([
                'driver_id' => $request->driver_id,
                'bank_name' => $request->bank_name,
                'person_name'=> $request->person_name ,
                'money'   => $request->money,
                'state' => 'pending',
                'transfer_photo'   => $image,
                
            ]);
            return $this -> returnData('data' , $bankTransfer, 'add transfer successfully watting for review');  
        }
    }

    public function show_driver(Request $request)
    {
        $request->validate([
            'driver_id'   => 'required|string'            
        ]);
        $data = \App\Models\Driver\BankTransferDriver::where('driver_id', $request->driver_id)->paginate(10);;
        return $this -> returnData('data' , $data, 'request for bank transfer add balance');  

    }
}
