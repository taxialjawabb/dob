<?php

namespace App\Http\Controllers\Admin\Tasks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tasks\Task;
use App\Models\Tasks\Result;
use App\Models\Admin;
use App\Models\RiderSupport\RiderSupportTask;
use App\Models\RiderSupport\RiderSupportResult;
use Illuminate\Support\Facades\DB;

class ShowTaskController extends Controller
{
    public function show($id, $type)
    {
        if($type === 'admin'){
            $task = Task::find($id);
            if($task !== null){
                $results = DB::select(" select 'admin' as type, results.add_date as addDateIn, results.content , admins.name 
                from results , admins where results.add_by = admins.id and results.task_id = ? order by addDateIn", [$id]);
                
                return view('tasks.detialsTask', compact('task', 'results'));
            }          
        }else if($type === 'rider'){
            $task = RiderSupportTask::find($id);
            if($task !== null){
                $results = DB::select("
                select 'admin' as type, rider_task_results.add_date as addDateIn, rider_task_results.content , admins.name 
                from rider_task_results , admins where rider_task_results.add_by = admins.id and rider_task_results.added_type ='admin' and rider_task_results.task_id =?
                union all
                select 'rider' as type, rider_task_results.add_date  as addDateIn, rider_task_results.content , rider.name 
                from rider_task_results , rider where rider_task_results.add_by = rider.id and rider_task_results.added_type ='rider' and rider_task_results.task_id =? order by addDateIn
                
                ", [$id , $id]);
                
                return view('tasks.detialsTask', compact('task', 'results'));
            }          
        }
        return back();
        
    }
    public function direct($id, $type)
    {
        if($type === 'admin'){
            $task = Task::find($id);
            if($task !== null){
                $user = Admin::select(['id','name','department'])->find($task->readed_by);
                $results = Result::select(['add_date' , 'content'])->where('task_id' , $id)->orderBy('add_date','desc')->get();
                $task->type = "admin";
                return view('tasks.directTask', compact('task', 'results', 'user'));
            }          
        }
        if($type === 'rider'){
            $task = RiderSupportTask::find($id);
            if($task !== null){
                $user = Admin::select(['id','name','department'])->find($task->admin_id);
                $results = RiderSupportResult::select(['add_date' , 'content'])->where('task_id' , $id)->orderBy('add_date','desc')->get();
                $task->type = "rider";
                return view('tasks.directTask', compact('task', 'results', 'user'));
            }          
        }
        return back();
    }
    public function direct_save(Request $request)
    {
        
        $request->validate([            
            'user_id' =>     'required|integer',
            'department' =>  'required|string|in:management,technical',
            'task_id' =>        'required|string',
            'type' =>        'required|string|in:admin,rider',
        ]);
        if($request->type === 'admin'){
            $task = Task::find($request->task_id);
            if($task !== null){
                $task->department = $request->department;
                // $task->add_by  = auth()->user()->id;
                $task->readed_by = $request->user_id;
                $task->save();
                return redirect('tasks/show/'.$task->state);
            }
        }
        else if($request->type === 'rider'){
            $task = RiderSupportTask::find($request->task_id);
            if($task !== null){
                $task->department = $request->department;
                $task->direct_by = auth()->user()->id;
                $task->admin_id = $request->user_id;
                $task->save();
                return redirect('tasks/show/'.$task->state);
            }

        }
        return back();
    }
}
