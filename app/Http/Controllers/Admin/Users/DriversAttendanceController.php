<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Driver;
use App\Models\User\EmployeeAttendance;
use App\Models\Driver\DriverEmployeeAttendance;
use App\Models\Driver\DriverEmployeeMonthlySalary;
use App\Models\User\EmployeeMonthlySalary;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriversAttendanceController extends Controller
{
    public function show_driver_employee($type)
    {
        $data = [];
        if($type === 'active'){
            $data = Driver::select(['id', 'name', 'phone','admin_id'])->where('state', 'active')->whereNull('group_id')->with('added_by:id,name')->get();
        }
        else{
            $data = Driver::select(['id', 'name', 'phone'])->where('state', '!=', 'active')->whereNull('group_id')->with('added_by:id,name')->get();
        }
        // return $data;
        return view('admin.users.driver_employee.driverEmployee', compact('data', 'type'));

    }
    public function report_salary_all()
    {

        $data = DB::select("select count(id) bills, DATE_FORMAT(created_at,'%Y-%m') as salary_date, sum(final_salary) total_salary from employees_driver_monthly_salary group by DATE_FORMAT(created_at,'%Y-%m');");
        return view('admin.users.driver_employee.attendaceDriverReportsSalary', compact('data'));
    }
    function add_attendance(Request $request){
        $request->validate([
            "reason" => "required|string",
            "absence_type" => "required|string|in:absence,vacation,delay",
            "user_id" => "required|numeric"
        ]);
        // return $request->all();

        $user = Driver::select(['id', 'name', 'vacation_days_remains'])->find($request->user_id);
        if($user != null){
            $data = DriverEmployeeAttendance::where('driver_id' , $user->id )->where('date_is' , Carbon::now()->format('y-m-d'))->get();
            if(count($data) ===0){
                if($request->absence_type === 'absence'){
                    $this->addAttendance($request);
                    $request->session()->flash('status', 'تم إضافة اليوم غياب السائق: '. $user->name);
                }
                else if($request->absence_type === 'vacation'){
                    if($user->vacation_days_remains > 0){
                        $user->vacation_days_remains --;
                        $user->save();
                        $this->addAttendance($request);
                        $request->session()->flash('status', 'تم إضافة اليوم أجازة السائق: '. $user->name);
                    }
                    else{
                        $request->session()->flash('error', 'لقد تم أتسهلاك الأجازة السنوية كاملة السائق:  '. $user->name);
                    }
                }
                else if($request->absence_type === 'delay'){
                    $request->validate([
                        "delay_hours" => "required|numeric|min:0.5|max:8"
                    ]);

                    $this->addAttendance($request);
                    $request->session()->flash('status', 'تم إضافة ساعات تأخير اليوم السائق: '. $user->name);
                }
            }
            else{
                switch ($data[0]->absence_type) {
                    case 'absence':
                        $request->session()->flash('error', 'لقد تم تسجيل اليوم غياب لهذا الموظف من قبل.');
                        break;
                    case 'vacation':
                        $request->session()->flash('error', 'لقد تم تسجيل اليوم أجازة لهذا الموظف من قبل.');
                        break;
                    case 'delay':
                        $request->session()->flash('error', 'لقد تم تسجيل ساعات تأخير اليوم لهذا الموظف من قبل.');
                        break;
                    default:
                        $request->session()->flash('error', 'حدث خطاء فى التسجيل الرجاء مراجعة الدعم.');
                        break;
                }
            }
        }else{
            $request->session()->flash('error', 'حدث خطاء فى البيانات المرسلة الرجاء المحاولة لاحقا');
        }
        return back();
    }


    public function show_attendance(Request $request){
        $request->validate([
            "user_id" => "required|numeric",
            "absence_type" => "required|string|in:absence,vacation,delay",
            "date" => "required|date",
        ]);

        $dateFormat =  Carbon::parse($request->date);

        $data = DriverEmployeeAttendance::where('driver_id' , $request->user_id)
                                    ->where('absence_type', $request->absence_type)
                                    ->whereYear('date_is', $dateFormat->year)
                                    ->whereMonth('date_is', $dateFormat->month)
                                    ->with('user_data')->get();
        $counted = DriverEmployeeAttendance::where('driver_id' , $request->user_id)
                                    ->where('absence_type', $request->absence_type)
                                    ->whereYear('date_is', $dateFormat->year)
                                    ->whereMonth('date_is', $dateFormat->month)->count();
        $hours = 0;
        if($request->absence_type === 'delay'){
            $hours = DriverEmployeeAttendance::where('driver_id' , $request->user_id)
            ->where('absence_type', $request->absence_type)
            ->whereYear('date_is', $dateFormat->year)
            ->whereMonth('date_is', $dateFormat->month)->sum('delay_hours');
        }
        return view('admin.users.attendanceUser', compact('data', 'counted', 'hours', 'request'));
    }


    private function addAttendance($request){
        $attendance = new DriverEmployeeAttendance();
        $attendance->date_is = Carbon::now()->format('y-m-d');
        $attendance->reason = $request->reason;
        $attendance->absence_type = $request->absence_type;
        $attendance->add_date = Carbon::now();
        $attendance->added_by = Auth::guard('admin')->user()->id;
        $attendance->driver_id = $request->user_id;
        if($request->delay_hours !== null){
            $attendance->delay_hours = $request->delay_hours;
        }
        $attendance->save();
    }

    public function report_salary(Request $request){

        $dateFormat =  Carbon::parse($request->date);
        $data = DriverEmployeeMonthlySalary::whereYear('created_at', $dateFormat->year)
        ->whereMonth('created_at', $dateFormat->month)->with('user_data')->with('confirmed')->get();
        $total = DriverEmployeeMonthlySalary::whereYear('created_at', $dateFormat->year)
        ->whereMonth('created_at', $dateFormat->month)->sum('final_salary');

        $confirm = false;
        if(count($data)> 0){
            if($data[0]->confirmed === null)
                $confirm = true;
        }
         return view('admin.users.attendaceMonthlyUser', compact('data', 'total', 'dateFormat' , 'confirm'), );

    }
    public function report_confirm(Request $request)
    {
        $request->validate([
            "date" => "required|date",
        ]);
        $dateFormat =  Carbon::parse($request->date);

        $data = DriverEmployeeMonthlySalary::whereYear('created_at', $dateFormat->year)
        ->whereMonth('created_at', $dateFormat->month)->get();
        foreach ($data as $user) {
            $boxUser = new \App\Models\Driver\BoxDriver();
            $boxUser->driver_id = $user->driver_id;
            $boxUser->bond_type = 'spend';
            $boxUser->payment_type = 'bank transfer';
            $boxUser->money = $user->final_salary;
            $boxUser->tax = 0;
            $boxUser->total_money = $user->final_salary;
            $boxUser->descrpition =  $user->note;
            $boxUser->add_date = Carbon::now();
            $boxUser->add_by = Auth::guard('admin')->user()->id;
            $boxUser->save();
            $user->confirmed_date = Carbon::now();
            $user->confirmed_by = Auth::guard('admin')->user()->id;
            $user->save();
        }
        $request->session()->flash('status', 'تم اعتماد الرواتب السائقين شهر: '. $request->date);
        return back();
    }
}
