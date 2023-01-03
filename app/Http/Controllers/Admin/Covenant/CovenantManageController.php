<?php

namespace App\Http\Controllers\Admin\Covenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Covenant\Covenant;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Covenant\CovenantRecord;
use App\Models\Covenant\CovenantItem;
use Illuminate\Support\Facades\Http;

class CovenantManageController extends Controller
{
    public function show()
    {
        $covenants = Covenant::withCount('items')->with('added_by')->with('delivered_to')->get();
        // return $covenants;
        return view('covenant.showCovenant', compact('covenants'));
    }

    public function show_user()
    {
        $covenants = Covenant::where('delivered_user', Auth::guard('admin')->user()->id)
                    ->withCount('items')->get();
        // return $covenants;


        return view('covenant.showUserCovenant', compact('covenants'));
    }

    public function show_add()
    {
        return view('covenant.addCovenant');
    }
    public function save_add(Request $request)
    {
        $request->validate([
            'covenant_name'=>'required|string'
        ]);
        $data = Covenant::where('covenant_name',$request->covenant_name)->get();
        if(count($data) === 0){
            $covenant = new Covenant;
            $covenant->covenant_name = $request->covenant_name;
            $covenant->add_by = Auth::guard('admin')->user()->id;
            $covenant->add_date = Carbon::now();
            $covenant->save();
            $request->session()->flash('status', 'تم أضافة العهد بنجاح');
            return redirect('covenant/show');

        }
        else{
            $request->session()->flash('error', 'خطاء اسم العهدة موجود مسبقا');
            return redirect('covenant/show');
        }
    }

    public function receive_to_user(Request $request)
    {
        $request->validate([
            'user_id'=>'required|integer'
        ]);
        $covenantItems = CovenantItem::where("state" , null)->orWhere("state",'=' ,'waiting')->get();
        foreach ($covenantItems as $covenantItem) {
            $prevUserReceive =  CovenantRecord::where('item_id', $covenantItem->id)
                                                ->where('forign_type', 'user')
                                                ->where('receive_date', null)->get();
            if(count($prevUserReceive) >0){
                $prevUserReceive[0]->receive_date = Carbon::now();
                $prevUserReceive[0]->receive_by = Auth::guard('admin')->user()->id;
                $prevUserReceive[0]->save();
            }
            $covenantItem-> delivery_date = Carbon::now();
            $covenantItem-> current_driver = null;
            $covenantItem-> state = 'waiting' ;
            $covenantRecord  = new  CovenantRecord;
            $covenantRecord->forign_type = 'user';
            $covenantRecord->forign_id = $request->user_id;
            $covenantRecord->item_id = $covenantItem->id;
            $covenantRecord->delivery_date = Carbon::now();
            $covenantRecord->delivery_by = Auth::guard('admin')->user()->id;

            $covenantItem->save();
            $covenantRecord->save();
        }
        return back();
    }
    public function show_deliver()
    {

        $covenants = DB::select('
        select covenant.id as id, covenant.covenant_name , count(covenant_items.id) as counts,
        admins.name as  add_by, covenant.add_date from covenant left join admins on covenant.add_by = admins.id
        left join covenant_items on covenant_items.covenant_name = covenant.covenant_name
        group by covenant.covenant_name order by covenant.id;
    ');
    return view('covenant.showCovenantDelivery', compact('covenants'));

    }

    public function send_code_user(Request $request)
    {
        $request->validate([
        'user_id' => 'required|integer',
        "covenant"    => "required|array|min:1",

        ]);
        $user = \App\Models\Admin::select(['id', 'phone'])->find($request->user_id);

        if($user !== null){
            $code = rand(1000,9999);
            //  return $this->returnData('code', $code);
            $now =  \Carbon\Carbon::now();
            $token = env('SMS_TOKEN', '');
            $phone = '966'.substr($user->phone, 1);
            $message = "كود التحقيق لتسليم العهد للموظف: ".$code . "\n العهد:";
            foreach ($request->covenant as $covenant) {
                $message .="\n".$covenant;
            }
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => $token
            ])->post('https://api.taqnyat.sa/v1/messages', [
                "recipients" =>  [
                    $phone
                ],
                "body" => $message,
                "sender" => "TaxiAljawab",
                "scheduledDatetime" =>  $now
            ]);
            $resp = json_decode($response);

            if($resp->statusCode === 201){
                return $this->returnData('code', $code);
            }
            else{
                return $this->returnError('E002', 'خطاء فى ارسال الرسالة');
            }
        }
        else{
            return $this->returnError('E001', 'خطاء فى بيانات السائق');
        }
    }

    public function save_deliver(Request $request)
    {
    $request->validate([
        'user_id'=>'required|integer',
        "covenant"    => "required|array|min:1",
    ]);

    $covenantItems = CovenantItem::whereIn('covenant_name',$request->covenant)->
                                   whereIn("state" , [null,'waiting'])->get();
    Covenant::whereIn('covenant_name',$request->covenant)->update(['delivered_user'=>$request->user_id]);

    foreach ($covenantItems as $item) {

        $prevUserReceive =  CovenantRecord::where('item_id', $item->id)
                                           ->where('forign_type', 'user')
                                           ->orderBy('id', 'desc')->first();

        if ($prevUserReceive !=null) {

            $prevUserReceive->receive_date = Carbon::now();
            $prevUserReceive->receive_by = Auth::guard('admin')->user()->id;
            $prevUserReceive->save();
            $record=new CovenantRecord();
            $record->delivery_date  =$prevUserReceive->receive_date;
            $record->delivery_by   =$prevUserReceive->receive_by;
            $record->forign_type   ='user';
            $record->forign_id     =$request->user_id;
            $record->item_id       =$prevUserReceive->item_id;
            $record->save();
         }
        $record=new CovenantRecord();
        $record->delivery_date  =Carbon::now();
        $record->delivery_by   =Auth::guard('admin')->user()->id;
        $record->forign_type   ='user';
        $record->forign_id     =$request->user_id;
        $record->item_id       =$item->id;
        $record->save();


    }
    $request->session()->flash('status', 'تم تسليم العهد المحدده بنجاح');
    return $this->returnSuccessMessage("covenant delivered successfully");
}
}
