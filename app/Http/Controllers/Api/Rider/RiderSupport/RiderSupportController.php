<?php

namespace App\Http\Controllers\Api\Rider\RiderSupport;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiderSupport\RiderSupportTask;
use App\Models\RiderSupport\RiderSupportResult;
use Carbon\Carbon;
use App\Traits\GeneralTrait;
use App\Models\Rider;

class RiderSupportController extends Controller
{
    use GeneralTrait;
    public function add_task(Request $request)
    {
        $request->validate([
            'rider_id' =>'required|string',
            'title' =>'required|string',
            'content' =>'required|string',
            ]);
            

        $rider = Rider::find($request->rider_id);
        if($rider !== null){
            $riderTask = RiderSupportTask::create([
                'rider_id' => $request->rider_id,
                'subject' => $request->title,
                'content'=> $request->content ,
                'state' => 'unseen',
            ]);
            return $this -> returnData('data' , $riderTask, 'add task successfully');   
        }
        else{
            return $this->returnError('E001',"خطاء فى بيانات العميل المدخلة");
        }
    }

    public function show_task(Request $request)
    {
        $request->validate([
            'rider_id' =>'required|string',
            ]);

            $rider = Rider::find($request->rider_id);
            if($rider !== null){
                $riderTask = RiderSupportTask::where('rider_id',$request->rider_id)
                ->with(['results' => function ( $riderSupportResult) {
                    $riderSupportResult->orderBy('add_date','desc');
                }])->paginate(10);
                // $riderTask = RiderSupportTask::select([
                //     'id',
                //     'subject',
                //     'content',
                //     'state',
                //     'created_at',
                
                // ])->where('rider_id', $rider->id)->with('results')
                // ->paginate(10);
                return $this -> returnSuccessMessage($riderTask);   
        }
        else{
            return $this->returnError('E001',"خطاء فى بيانات العميل المدخلة");
        }
    }
   
    public function send_replay_task(Request $request)
    {
        
        $request->validate([
            'task_id' =>'required|string',
            'rider_id' =>'required|string',
            'content' =>'required|string',
            ]);
        $riderTask = RiderSupportTask::find($request->task_id);
        if($riderTask !== null){
            $riderTaskResult = RiderSupportResult::create([
                'add_date'=> Carbon::now(),
                'content' => $request->content,
                'task_id' => $request->task_id,
                'added_type' => 'rider',
                'add_by' => $riderTask->rider_id,
            ]);
            return $this -> returnSuccessMessage('data' , $riderTaskResult, 'add task result successfully');   
        }
        else{
            return $this->returnError('E001',"خطاء فى بيانات العميل المدخلة");
        }
    }
}
