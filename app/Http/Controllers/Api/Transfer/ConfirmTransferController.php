<?php

namespace App\Http\Controllers\Api\Transfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;

class ConfirmTransferController extends Controller
{
    use GeneralTrait;
    public function transfer_rider(Request $request)
    {
        $request->validate([
            'rider_id'   => 'required|string',
            'type'    => 'required|string|in:driver,rider',
            'transfer_to'    => 'required|string',
            'phone'    => 'required|string|min:10|max:10',
            'money'   => 'required|numeric'
        ]);
        $rider = \App\Models\Rider::select(['id', 'name', 'phone', 'account'])->find($request->rider_id);
        if($rider === null){
            return $this->returnError('E005',"حدث خطاء ما الرجاء المحاولة مرة اخرى");
        }
        if($request->type === 'driver'){
            $data = \App\Models\Driver::select(['id', 'name', 'phone' , 'account', 'remember_token'])
                                        ->where("id" , $request->transfer_to)
                                        ->where("phone" , $request->phone)->get();
            if(count($data) > 0){
                if($rider->account > $request->money){
                    $descrpition = 'قام العميل : '.$rider->name.'  رقم الهاتف '.$rider->phone .' بتحويل مبلغ وقدرة: '.$request->money.' إلى رصيد السائق: ' .$data[0]->name . '  رقم الهاتف '. $data[0]->phone;

                    $boxDriver = new \App\Models\Driver\BoxDriver;
                    $boxDriver->driver_id = $data[0]->id;
                    $boxDriver->bond_type = 'take';
                    $boxDriver->payment_type = 'internal transfer';
                    $boxDriver->bond_state = 'deposited';
                    $boxDriver->money = $request->money;
                    $boxDriver->tax = 0;
                    $boxDriver->total_money = $request->money;
                    $boxDriver->descrpition = $descrpition;
                    $boxDriver->add_date = \Carbon\Carbon::now();
                    $boxDriver->confirm_by = -2;
                    $boxDriver->trustworthy_by = -2;
                    

                    $BoxRider = new \App\Models\Rider\BoxRider;
                    $BoxRider->rider_id = $rider->id;
                    $BoxRider->bond_type =  'spend' ;
                    $BoxRider->payment_type = 'internal transfer';
                    $BoxRider->bond_state = 'deposited';
                    $BoxRider->money = $request->money;
                    $BoxRider->tax = 0;
                    $BoxRider->total_money = $request->money;
                    $BoxRider->descrpition = $descrpition;
                    $BoxRider->add_date = \Carbon\Carbon::now();
                    $BoxRider->confirm_by = -1;
                    $BoxRider->trustworthy_by = -1;

                    $BoxRider->save();
                    $boxDriver->save();

                    $rider->account -= $request->money; 
                    $data[0]->account += $request->money; 
                    $rider->save();
                    $data[0]->save();
                    $this->push_notification($data[0]->remember_token, 'تم تحويل رصيد إلى حسابك' , $descrpition , 'transfer');

                    return $this -> returnSuccessMessage($descrpition);

                }else{
                    return $this->returnError('E001',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('E002',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");

            }
        }
        else if($request->type === 'rider')
        {
            $data = \App\Models\Rider::select(['id', 'name', 'phone' , 'account', 'remember_token'])
                                        ->where("id" , $request->transfer_to)
                                        ->where("phone" , $request->phone)->get();
            if(count($data) > 0){
                if($rider->account > $request->money){
                    $descrpition = 'قام العميل : '.$rider->name.'  رقم الهاتف '.$rider->phone .' بتحويل مبلغ وقدرة: '.$request->money.' إلى رصيد العميل: ' .$data[0]->name . '  رقم الهاتف '. $data[0]->phone;

                    $boxTransferTo = new \App\Models\Rider\BoxRider;
                    $boxTransferTo->rider_id = $data[0]->id;
                    $boxTransferTo->bond_type = 'take';
                    $boxTransferTo->payment_type = 'internal transfer';
                    $boxTransferTo->bond_state = 'deposited';
                    $boxTransferTo->money = $request->money;
                    $boxTransferTo->tax = 0;
                    $boxTransferTo->total_money = $request->money;
                    $boxTransferTo->descrpition = $descrpition;
                    $boxTransferTo->add_date = \Carbon\Carbon::now();
                    $boxTransferTo->confirm_by = -2;
                    $boxTransferTo->trustworthy_by = -2;
                    

                    $BoxRider = new \App\Models\Rider\BoxRider;
                    $BoxRider->rider_id = $rider->id;
                    $BoxRider->bond_type =  'spend' ;
                    $BoxRider->payment_type = 'internal transfer';
                    $BoxRider->bond_state = 'deposited';
                    $BoxRider->money = $request->money;
                    $BoxRider->tax = 0;
                    $BoxRider->total_money = $request->money;
                    $BoxRider->descrpition = $descrpition;
                    $BoxRider->add_date = \Carbon\Carbon::now();
                    $BoxRider->confirm_by = -1;
                    $BoxRider->trustworthy_by = -1;

                    $BoxRider->save();
                    $boxTransferTo->save();

                    $rider->account -= $request->money; 
                    $data[0]->account += $request->money; 
                    $rider->save();
                    $data[0]->save();
                    $this->push_notification($data[0]->remember_token, 'تم تحويل رصيد إلى حسابك' , $descrpition , 'transfer');

                    return $this -> returnSuccessMessage($descrpition);

                }else{
                    return $this->returnError('E001',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('E002',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");

            }
        }
        else{
            return $this->returnError('E003',"الرجاء التأكد من الجهة المحول لها  ");
        }
        
    }

    public function transfer_driver(Request $request)
    {
        $request->validate([
            'driver_id'   => 'required|string',
            'type'    => 'required|string|in:driver,rider',
            'transfer_to'    => 'required|string',
            'phone'    => 'required|string|min:10|max:10',
            'money'   => 'required|numeric'
        ]);
        $driver = \App\Models\Driver::select(['id', 'name', 'phone', 'account'])->find($request->driver_id);
        if($driver === null){
            return $this->returnError('100008',"حدث خطاء ما الرجاء المحاولة مرة اخرى");
        }
        if($request->type === 'driver'){
            $data = \App\Models\Driver::select(['id', 'name', 'phone' , 'account', 'remember_token'])
                                        ->where("phone" , $request->phone)->get();
            if(count($data) > 0){
                if($driver->account > $request->money){
                    $descrpition = 'قام السائق : '.$driver->name.'  رقم الهاتف '.$driver->phone .' بتحويل مبلغ وقدرة: '.$request->money.' إلى رصيد السائق: ' .$data[0]->name . '  رقم الهاتف '. $data[0]->phone;

                    $boxTranferTo = new \App\Models\Driver\BoxDriver;
                    $boxTranferTo->driver_id = $data[0]->id;
                    $boxTranferTo->bond_type = 'take';
                    $boxTranferTo->payment_type = 'internal transfer';
                    $boxTranferTo->bond_state = 'deposited';
                    $boxTranferTo->money = $request->money;
                    $boxTranferTo->tax = 0;
                    $boxTranferTo->total_money = $request->money;
                    $boxTranferTo->descrpition = $descrpition;
                    $boxTranferTo->add_date = \Carbon\Carbon::now();
                    $boxTranferTo->confirm_by = -2;
                    $boxTranferTo->trustworthy_by = -2;
                    

                    $boxDriver = new \App\Models\Driver\BoxDriver;
                    $boxDriver->driver_id = $driver->id;
                    $boxDriver->bond_type =  'spend' ;
                    $boxDriver->payment_type = 'internal transfer';
                    $boxDriver->bond_state = 'deposited';
                    $boxDriver->money = $request->money;
                    $boxDriver->tax = 0;
                    $boxDriver->total_money = $request->money;
                    $boxDriver->descrpition = $descrpition;
                    $boxDriver->add_date = \Carbon\Carbon::now();
                    $boxDriver->confirm_by = -1;
                    $boxDriver->trustworthy_by = -1;

                    $boxDriver->save();
                    $boxTranferTo->save();

                    $driver->account -= $request->money; 
                    $data[0]->account += $request->money; 
                    $driver->save();
                    $data[0]->save();
                    $this->push_notification($data[0]->remember_token, 'تم تحويل رصيد إلى حسابك' , $descrpition , 'transfer');

                    $data = (object)[
                        'message_transfer'=>(string)$descrpition,
                        'success_transfer'=>true,
                        'id_transfer'=>(string)$boxDriver->id,
                        
                    ];
                    return $this -> returnData($data,"success treansfer");

                }else{
                    return $this->returnError('100011',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('100012',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");

            }
        }
        else if($request->type === 'rider')
        {
            $data = \App\Models\Rider::select(['id', 'name', 'phone' , 'account', 'remember_token'])
                                        ->where("phone" , $request->phone)->get();
            if(count($data) > 0){
                if($driver->account > $request->money){
                    $descrpition = 'قام السائق : '.$driver->name.'  رقم الهاتف '.$driver->phone .' بتحويل مبلغ وقدرة: '.$request->money.' إلى رصيد العميل: ' .$data[0]->name . '  رقم الهاتف '. $data[0]->phone;

                    $boxTransferTo = new \App\Models\Rider\BoxRider;
                    $boxTransferTo->rider_id = $data[0]->id;
                    $boxTransferTo->bond_type = 'take';
                    $boxTransferTo->payment_type = 'internal transfer';
                    $boxTransferTo->bond_state = 'deposited';
                    $boxTransferTo->money = $request->money;
                    $boxTransferTo->tax = 0;
                    $boxTransferTo->total_money = $request->money;
                    $boxTransferTo->descrpition = $descrpition;
                    $boxTransferTo->add_date = \Carbon\Carbon::now();
                    $boxTransferTo->confirm_by = -2;
                    $boxTransferTo->trustworthy_by = -2;
                    

                    $boxDriver = new \App\Models\Driver\BoxDriver;
                    $boxDriver->driver_id = $driver->id;
                    $boxDriver->bond_type =  'spend' ;
                    $boxDriver->payment_type = 'internal transfer';
                    $boxDriver->bond_state = 'deposited';
                    $boxDriver->money = $request->money;
                    $boxDriver->tax = 0;
                    $boxDriver->total_money = $request->money;
                    $boxDriver->descrpition = $descrpition;
                    $boxDriver->add_date = \Carbon\Carbon::now();
                    $boxDriver->confirm_by = -1;
                    $boxDriver->trustworthy_by = -1;

                    $boxDriver->save();
                    $boxTransferTo->save();

                    $driver->account -= $request->money; 
                    $data[0]->account += $request->money; 
                    $driver->save();
                    $data[0]->save();
                    $this->push_notification($data[0]->remember_token, 'تم تحويل رصيد إلى حسابك' , $descrpition , 'transfer');

                    $data = (object)[
                        'message_transfer'=>(string)$descrpition,
                        'success_transfer'=>true,
                        'id_transfer'=>(string)$boxDriver->id,
                        
                    ];
                    return $this -> returnData($data,"success treansfer");

                }else{
                    return $this->returnError('100011',"لا يوجد رصيد كافى ");
                }
            }else{
                return $this->returnError('100012',"لا يوجد بيانات بهذا الرقم الرجاء التأكد من البيانات ");

            }
        }
        else{
            return $this->returnError('100012',"الرجاء التأكد من الجهة المحول لها  ");
        }
        
    }
}
