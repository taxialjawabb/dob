<?php

namespace App\Http\Controllers\Admin\SendMessage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\Driver\DriverNotes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SendMessageDriverController extends Controller
{
    public function show($type)
    {
        $drivers = [];
        if($type === 'active' || $type === 'waiting'){
            $drivers = DB::select('select id, name, phone from driver where state = ? ', [$type]);
        }else{
            $drivers = DB::select('select id, name, phone from driver');
        }
        return view('sendMessages.sendDriverMessage', compact('drivers', 'type'));
    }

    public function send_message(Request $request)
    {
        $request->validate([
            'phones' =>     'required|array|min:1'
        ]);

        $drivers = \App\Models\Driver::select(['id', 'phone'])
                    ->whereIn('id', $request->phones)->get();

        $phones = [];
        for ($i=0; $i < count($drivers) ; $i++) {
            $phones[$i] = '966'.substr($drivers[$i]->phone, 1);
            $note = new DriverNotes;
            $note->note_type = 'رسالة نصية الى السائق';
            $note->content =  $request->content;
            $note->add_date = Carbon::now();
            $note->admin_id = Auth::guard('admin')->user()->id;
            $note->driver_id = $drivers[$i]->id;
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
            $request->session()->flash('status', 'تم أرسال الرسالة  للسائقين المحددين بنجاح');
        }
        else{
            $request->session()->flash('error', 'حدث خطاء فى ارسال الرسالة للسائقين المحددين');
        }
        return back();
    }
}
