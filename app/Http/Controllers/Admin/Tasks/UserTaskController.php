<?php

namespace App\Http\Controllers\Admin\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Tasks\Task;
use App\Models\Tasks\Result;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RiderSupport\RiderSupportTask;
use App\Models\RiderSupport\RiderSupportResult;

class UserTaskController extends Controller
{
    public function show_tasks($state)
    {
        if($state == 'unseen' || $state == 'seen' || $state == 'uncomplete'  ){
    
            $user_id = Auth::guard('admin')->user()->id;
            

            // return dd($department);
            $tasks = DB::select(" 
            select 'admin' as type, tasks.id, tasks.department, 
            ad1.name as add_admin, subject, content, tasks.state, tasks.created_at,
            readed_date, ad2.name as readed_admin, tasks.updated_at, finish_date
            from tasks left join admins ad1 on tasks.add_by = ad1.id 
            left join admins ad2 on tasks.readed_by= ad2.id where tasks.state = ? and tasks.readed_by = ? 
            union all
            select 'admin' as type, tasks.id, tasks.department, 
            ad1.name as add_admin, subject, content, tasks.state, tasks.created_at,
            readed_date, ad2.name as readed_admin, tasks.updated_at, finish_date
            from tasks left join admins ad1 on tasks.add_by = ad1.id 
            left join admins ad2 on tasks.readed_by= ad2.id where tasks.state = ? and tasks.add_by = ?
            " ,
            [$state, $user_id, $state, $user_id]);
            if($state === 'unseen'){
                $admintasks = Task::where('readed_by', $user_id)->where('state' , "unseen")->get();
                foreach ($admintasks as $task) {
                    $task->state = 'seen';
                    $task->readed_date = Carbon::now();
                    $task->save();
                }
                $riderTasks = RiderSupportTask::where('admin_id', $user_id)->where('state' , "unseen")->get();
                foreach ($riderTasks as $task) {
                    $task->state = 'seen';
                    $task->readed_date = Carbon::now();
                    $task->save();
                }
            }
        return view('tasks.user_tasks.showTasks', compact('tasks', 'state'));
    }
    else{
            return back();
        }        
    }
    public function show_complete_tasks($state)
    {
        if($state == 'complete' ){
            $department = Auth::guard('admin')->user()->department;
            $user_id = Auth::guard('admin')->user()->id;
            // return dd($department);
            $tasks = DB::select("
            select 'admin' as type, tasks.id, tasks.department, 
            ad1.name as add_admin, subject, content, tasks.state, tasks.created_at,
            readed_date, ad2.name as readed_admin, tasks.updated_at, finish_date
            from tasks left join admins ad1 on tasks.add_by = ad1.id 
            left join admins ad2 on tasks.readed_by= ad2.id where tasks.state = ? and tasks.readed_by = ?
            union all
            select 'admin' as type, tasks.id, tasks.department, 
            ad1.name as add_admin, subject, content, tasks.state, tasks.created_at,
            readed_date, ad2.name as readed_admin, tasks.updated_at, finish_date
            from tasks left join admins ad1 on tasks.add_by = ad1.id 
            left join admins ad2 on tasks.readed_by= ad2.id where tasks.state = ? and tasks.add_by = ?
            " , [$state, $user_id,$state, $user_id,]);
            
        return view('tasks.user_tasks.showTasks', compact('tasks', 'state'));
    }
    else{
            return back();
        }        
    }
    
    public function show_add($id, $type)
    {
        return view('tasks.user_tasks.completeTask', compact('id','type'));
    }

    public function save_tasks_result(Request $request)
    {
        $request->validate([            
            'id' => 'required|integer',
            'state' =>      'required|string',
            'result' =>'required|string',
            'type' =>'required|string',
        ]);
        
        if($request->type === 'admin'){
            $task = Task::find($request->id);
            if($task !== null){
                if($task->state != 'complete'){
                    $task->state = $request->state;
                    if($task->readed_by == null){
                        $task->readed_date = Carbon::now();
                        $task->readed_by = Auth::guard('admin')->user()->id;
                    }
                    if($request->state == 'complete')    {
                        $task->finish_date = Carbon::now();
                    }
                    $result = new Result;
                    $result->content = $request->result;
                    $result->task_id = $request->id;
                    $result->add_date = Carbon::now();
                    $result->add_by =  Auth::guard('admin')->user()->id;
                    
                    $result->save();
                    $task->save();
                }
                return redirect('tasks/detials/'. $request->id.'/'.$request->type);
            }
        }
        else if($request->type === 'rider'){
            $task = RiderSupportTask::find($request->id);
            if($task !== null){
                if($task->state != 'complete'){
                    $task->state = $request->state;
                    if($task->admin_id == null){
                        $task->readed_date = Carbon::now();
                        $task->admin_id = Auth::guard('admin')->user()->id;
                    }
                    if($request->state == 'complete')    {
                        $task->finish_date = Carbon::now();
                    }
                    $riderTaskResult = RiderSupportResult::create([
                        'add_date'=> Carbon::now(),
                        'content' => $request->result,
                        'task_id' => $request->id,
                        'added_type' => 'admin',
                        'add_by' => Auth::guard('admin')->user()->id,
                    ]);
                    $task->save();
                }
                return redirect('tasks/detials/'. $request->id.'/'.$request->type);
            }
        }
    return back();
        

    }
    public function recieved_task($id, $type)
    {    
        $readed_by = Auth::guard('admin')->user()->id;
        
        if($type === 'admin'){
            $task =Task::find($id);
            if($task !== null ){
                $task->state = 'seen';
                $task->readed_by = $readed_by;
                $task->readed_date = Carbon::now();
                $task->save();
            }
        }
        else if($type === 'rider'){
            $task =RiderSupportTask::find($id);
            if($task !== null ){
                $task->state = 'seen';
                $task->admin_id = $readed_by;
                $task->readed_date = Carbon::now();
                $task->save();
            }
        }

        return back();
    }
}
