<?php

namespace App\Http\Controllers\Api\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiderMessage;
use App\Traits\GeneralTrait;

class RiderMessageController extends Controller
{
    use GeneralTrait;

    public function RiderMessage(Request $request)
    {
        $request->validate([
            'rider_id'      => ['required'],
            'send_time'      => ['required', 'date'],
            'subject'      => ['required', 'string' ],
            'content'      => ['required', 'string' ],
            'message_state'      => ['required' ],
        ]);
        
        $message = new RiderMessage;
        $message->rider_id = $request->rider_id;
        $message->send_time = $request->send_time;
        $message->subject = $request->subject;
        $message->content = $request->content;
        $message->message_state = $request->message_state;
        $message->save();
        return $this->returnSuccessMessage('Message wast sent successfully');



        
    }
}
