<?php

namespace App\Http\Controllers\Admin\SendMessage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Rider\RiderNotes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SendMessageRiderController extends Controller
{
    public function show($type)
    {
        $riders = [];
        if($type === 'active' || $type === 'waiting'){
            $riders = DB::select('select id, name, phone from rider where state = ? ', [$type]);
        }else{
            $riders = DB::select('select id, name, phone from rider');
        }
        return view('sendMessages.sendRiderMessage', compact('riders', 'type'));
    }

    public function send_message(Request $request)
    {
        $request->validate([
            'phones' =>     'required|array|min:1'
        ]);

        $riders = \App\Models\Rider::select(['id', 'phone'])
                    ->whereIn('id', $request->phones)->get();
        $phones = [];
        for ($i=0; $i < count($riders) ; $i++) {
            $phones[$i] = '966'.substr($riders[$i]->phone, 1);
            $note = new RiderNotes;
            $note->note_type = 'رسالة نصية الى للعميل';
            $note->content =  $request->content;
            $note->add_date = Carbon::now();
            $note->admin_id = Auth::guard('admin')->user()->id;
            $note->rider_id = $riders[$i]->id;
            $note->save();
        }

        $now =  Carbon::now();
        $token = env('SMS_TOKEN', '');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $token
        ])->post('https://api.taqnyat.sa/v1/messages', [
            "recipients" =>  $phones,
            "body" => $request->content,
            "sender" => "TaxiAljawab",
            "scheduledDatetime" =>  $now
        ]);
        $resp = json_decode($response);

        if($resp->statusCode === 201){
            $request->session()->flash('status', 'تم أرسال الرسالة  للعملاء المحددين بنجاح');
        }
        else{
            $request->session()->flash('error', 'حدث خطاء فى ارسال الرسالة للعملاء المحددين');
        }
        return back();
    }
}
