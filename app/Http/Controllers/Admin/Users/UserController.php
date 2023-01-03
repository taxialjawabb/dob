<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Covenant\CovenantRecord;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function user_block($id)
    {
        $user = Admin::find($id);
        if ($user != null) {
            $userCovenants = CovenantRecord::where('forign_type', 'user')
                ->where('receive_by', null)->where('receive_date', null)->orderBy('delivery_date', 'desc')->get();
            if (count($userCovenants) > 0) {
                if ($userCovenants[0]->forign_id === $user->id) {
                    $stored = DB::select("
                                        select covenant_name, count(covenant_items.id) as numbers
                                        from covenant_items, covenant_record
                                        where covenant_items.id= covenant_record.item_id
                                        and forign_type ='user' and forign_id = ?
                                        and receive_by is null and receive_date is null
                                        group by covenant_name;
                    ", [$id]);

                    $covenants = DB::select("
                                            select covenant_items.id, covenant_items.serial_number,
                                            covenant_items.state, admins.name as admin_name,
                                            covenant_items.add_date, driver.name as driver_name, driver.phone, covenant_items.delivery_date
                                            from covenant_items  , driver , covenant_record , admins
                                            where covenant_items.current_driver = driver.id
                                            and  covenant_record.item_id = covenant_items.id
                                            and covenant_record.delivery_by = admins.id and covenant_record.delivery_by = ?
                    ", [$id]);

                    return view('admin.users.covenantUser', compact('covenants', 'stored', 'user'));
                }
            }
            $note = new \App\Models\User\UserNotes();
            $note->user_id =$user->id;
            $note->admin_id =  Auth::guard('admin')->user()->id;
            $note->add_date = Carbon::now();
            if ($user->state === "active") {

                /*================== calculate salary  ========*/
                if ($user->monthly_salary > 0) {
                    $today = \Carbon\Carbon::now();
                    // $endDateOfThisMonth = new \Carbon\Carbon('last day of this month');

                    $year = $today->year;
                    $month = $today->month;
                    $salaryPayed = \App\Models\User\EmployeeMonthlySalary::where('admin_id', $user->id)
                        ->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)->first();
                    if ($salaryPayed === null) {
                        $note = 'صرف راتب شهر: ' . $today->format('m / Y') . ' حتى تاريخ اليوم ' . $today->format('Y-m-d');
                        $day_salary = $user->monthly_salary / 30;
                        $dayesNotWorked = 0;
                        $dayesPriceNotWorked = 0;

                        if ($month == $user->date_join->month) {
                            $dayesNotWorked = $user->date_join->day - 1;
                            $note .= ' بدأ الشهر من ' . $user->date_join->format('Y-m-d') . ' ';
                        }
                        // $dayesNotWorked += $endDateOfThisMonth->day -$today->day +1;
                        $dayesNotWorked += 30 - $today->day + 1;
                        $dayesPriceNotWorked = $day_salary * $dayesNotWorked;

                        $counted = \App\Models\User\EmployeeAttendance::groupBy('absence_type')
                            ->select('admin_id', 'absence_type', DB::raw('count(*) as days'), DB::raw('sum(delay_hours) as delay_hours'))
                            ->where('admin_id', $user->id)
                            ->whereYear('date_is', $year)
                            ->whereMonth('date_is', $month)->get();
                        $vacations = 0;
                        $absence = 0;
                        $delay_days = 0;
                        $delay_hours = 0;
                        foreach ($counted as $count) {
                            switch ($count->absence_type) {
                                case 'absence':
                                    $absence = $count->days;
                                    $note .= " عدد أيام الغياب: " . $absence;
                                    break;
                                case 'vacation':
                                    $vacations = $count->days;
                                    $note .= " عدد أيام الأجازة: " . $vacations;
                                    break;
                                case 'delay':
                                    $delay_days = $count->days;
                                    $delay_hours = $count->delay_hours;
                                    $note .= " عدد أيام التأخير: " . $delay_days;
                                    $note .= " عدد ساعات التأخير: " . $delay_hours;
                                    break;

                                default:
                                    break;
                            }
                        }
                        $basic_salary = $user->monthly_salary - $user->monthly_deduct;
                        $hour_salary = $day_salary / 8;
                        $final_salary = $basic_salary - ($day_salary * $absence) - ($hour_salary * $delay_hours) - $dayesPriceNotWorked;
                        $monthSalaryReport = \App\Models\User\EmployeeMonthlySalary::create([
                            'total_salary' => $user->monthly_salary,
                            'basic_salary' => round($basic_salary, 2),
                            'deduction' => round($user->monthly_deduct, 2),
                            'vacation_days' => $vacations,
                            'absence_days' => $absence,
                            'delay_days_hours' => $delay_days,
                            'delay_hours' => $delay_hours,
                            'final_salary' => round($final_salary, 2),
                            'note' => $note,
                            'admin_id' => $user->id,
                        ]);

                    }
                }
                /*================== end calculate salary  ========*/
            
                $user->state = "blocked";
                $note->note_type = 'أستبعاد';
                $note->content = 'تم أستبعاد المستخدم ';
                session()->flash('status', 'تم أستبعاد المستخدم بنجاح');
            } else if ($user->state === "blocked") {
                $note->note_type = 'الغاء أستبعاد  ';
                $note->content = 'تم الغاء أستبعاد المستخدم ';
                $user->state = "active";
                session()->flash('status', 'تم إلغاء الأستبعاد للمستخدم بنجاح');
            }
            $note->save();
            $user->save();
        }
        return back();
    }

    public function confirm_block($id)
    {
        $user = Admin::find($id);
        if ($user != null) {
 

        
            if ($user->state === "active") {
            
                $user->state = "blocked";
                session()->flash('status', 'تم أستبعاد المستخدم بنجاح');
            } else if ($user->state === "blocked") {
     
                $user->state = "active";
                session()->flash('status', 'تم إلغاء الأستبعاد للمستخدم بنجاح');
            }
            
            $user->save();
            return redirect('user/detials/' . $user->id);
        }
        return back();
    }
}
