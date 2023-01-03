<?php

namespace App\Console\Commands;

use App\Models\Driver;
use App\Models\DriverVechile;
use App\Models\Driver\BoxDriver;
use App\Models\Groups\Group;
use App\Models\Groups\GroupBooking;
use App\Models\Nathiraat\Stakeholders;
use App\Models\Vechile;
use App\Models\Vechile\BoxVechile;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DailyRevenueDriver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:revenue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calaculate daily revenue for active driver has vechile';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // $data = DB::select('select driver.id as driver_id , driver.current_vechile ,vechile.id as vechile_id , driver_vechile.start_date_drive, driver_vechile.end_date_drive, category.category_name, category.percentage_type, category.daily_revenue_cost
        // from driver , vechile , driver_vechile, category where driver.id = driver_vechile.driver_id and vechile.id = driver_vechile.vechile_id and category.id = vechile.category_id and driver_vechile.end_date_drive is null and date(driver_vechile.start_date_drive) != CAST(NOW() AS DATE);');

        $data = DB::select('select driver.id as driver_id , driver.current_vechile ,vechile.id as vechile_id , driver_vechile.start_date_drive,
        driver_vechile.end_date_drive, vechile.daily_revenue_cost, vechile.maintenance_revenue_cost, vechile.identity_revenue_cost
        from driver , vechile , driver_vechile
        where driver.id = driver_vechile.driver_id and vechile.id = driver_vechile.vechile_id and
          driver_vechile.end_date_drive is null and date(driver_vechile.start_date_drive) != CAST(NOW() AS DATE);');
        $maintenance = Stakeholders::find(9);
        $identity = Stakeholders::find(10);
        for ($i = 0; $i < count($data); $i++) {
            if (Carbon::parse($data[$i]->start_date_drive)->hour === Carbon::now()->hour) {
                $driver = Driver::find($data[$i]->driver_id);
                $vechile = Vechile::find($data[$i]->vechile_id);
                if ($data[$i]->daily_revenue_cost > 0) {
                    $boxVechile = new BoxVechile;
                    $boxVechile->vechile_id = $data[$i]->vechile_id;
                    $boxVechile->foreign_type = 'driver';
                    $boxVechile->foreign_id = $data[$i]->driver_id;
                    $boxVechile->bond_type = 'take';
                    $boxVechile->payment_type = 'internal transfer';
                    $boxVechile->bond_state = 'deposited';
                    $boxVechile->descrpition = 'عائد يومى للمركبة ' . $data[$i]->vechile_id . ' على السائق ' . $driver->name;
                    $boxVechile->money = $data[$i]->daily_revenue_cost;
                    $boxVechile->tax = 0;
                    $boxVechile->total_money = $data[$i]->daily_revenue_cost;
                    $boxVechile->add_date = Carbon::now();
                    $driver->account -= $data[$i]->daily_revenue_cost;
                    $vechile->account += $data[$i]->daily_revenue_cost;
                    $boxVechile->save();
                }
                if ($data[$i]->maintenance_revenue_cost > 0) {
                    $boxDriver = new BoxDriver;
                    $boxDriver->driver_id = $data[$i]->driver_id;
                    $boxDriver->foreign_type = 'stakeholders';
                    $boxDriver->foreign_id = $maintenance->id;
                    $boxDriver->bond_type = 'spend';
                    $boxDriver->payment_type = 'internal transfer';
                    $boxDriver->bond_state = 'deposited';
                    $boxDriver->descrpition = 'عائد يومى لصيانة للمركبة ' . $data[$i]->driver_id . ' على السائق ' . $driver->name;
                    $boxDriver->money = $data[$i]->maintenance_revenue_cost;
                    $boxDriver->tax = 0;
                    $boxDriver->total_money = $data[$i]->maintenance_revenue_cost;
                    $boxDriver->add_date = Carbon::now();
                    $driver->account -= $data[$i]->maintenance_revenue_cost;
                    $maintenance->account += $data[$i]->maintenance_revenue_cost;
                    $boxDriver->save();
                }
                if ($data[$i]->identity_revenue_cost > 0) {
                    $boxDriver = new BoxDriver;
                    $boxDriver->driver_id = $data[$i]->driver_id;
                    $boxDriver->foreign_type = 'stakeholders';
                    $boxDriver->foreign_id = $identity->id;
                    $boxDriver->bond_type = 'spend';
                    $boxDriver->payment_type = 'internal transfer';
                    $boxDriver->bond_state = 'deposited';
                    $boxDriver->descrpition = 'عائد يومى للتجديد الإقامة ' . $data[$i]->driver_id . ' على السائق ' . $driver->name;
                    $boxDriver->money = $data[$i]->identity_revenue_cost;
                    $boxDriver->tax = 0;
                    $boxDriver->total_money = $data[$i]->identity_revenue_cost;
                    $boxDriver->add_date = Carbon::now();
                    $driver->account -= $data[$i]->identity_revenue_cost;
                    $identity->account += $data[$i]->identity_revenue_cost;
                    $boxDriver->save();
                }

                $driver->save();
                $vechile->save();

                $driver_vechile = DriverVechile::where('vechile_id', $data[$i]->vechile_id)
                    ->where('driver_id', $data[$i]->driver_id)
                    ->where('end_date_drive', null)->where('reason', null)
                    ->orderBy('start_date_drive', 'desc')
                    ->limit(1)->get();
                if (count($driver_vechile) > 0) {
                    $driver_vechile[0]->payedRegister += 1;
                    $driver_vechile[0]->save();
                }

            }
            $maintenance->save();
            $identity->save();

        }

        $endDateOfThisMonth = new Carbon('last day of this month');
        $lastDaysDateOfMonth = $endDateOfThisMonth->format('Y-m-d');
        // $today = new Carbon('2022-12-31 23:00:00');
        $today = new Carbon('now');
        $todayDate = $today->format('Y-m-d');
        if ($todayDate === $lastDaysDateOfMonth && $today->hour === 23) {
            // if($today->hour === 23){

            // Month Salary for employee
            $users = \App\Models\Admin::select(['id', 'working_hours', 'date_join', 'monthly_salary', 'monthly_deduct'])
                ->where('state', 'active')->where('monthly_salary', '>', 0)->get();
            $year = $today->year;
            $month = $today->month;

            foreach ($users as $user) {
                $note = 'صرف راتب شهر: ' . $today->format('m / Y');
                $day_salary = $user->monthly_salary / 30;
                $dayesNotWorked = 0;
                $dayesPriceNotWorked = 0;
                if ($endDateOfThisMonth->month == $user->date_join->month) {
                    $dayesNotWorked = $user->date_join->day - 1;
                    $dayesPriceNotWorked = $day_salary * $dayesNotWorked;
                    $note .= ' بدأ الشهر من ' . $user->date_join->format('y-m-d') . ' ';
                }

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

            // Month Salary for driver employee
            $users = \App\Models\Driver::select(['id', 'start_working_date', 'monthly_salary', 'monthly_deduct', 'insurances'])
                ->where('state', 'active')->where('on_company', 1)->where('monthly_salary', '>', 0)->get();

            foreach ($users as $user) {
                $note = 'صرف راتب شهر: ' . $today->format('m / Y');
                $day_salary = $user->monthly_salary / 30;
                $dayesNotWorked = 0;
                $dayesPriceNotWorked = 0;
                if ($endDateOfThisMonth->month == $user->start_working_date->month) {
                    $dayesNotWorked = $user->start_working_date->day - 1;
                    $dayesPriceNotWorked = $day_salary * $dayesNotWorked;
                    $note .= ' بدأ الشهر من ' . $user->start_working_date->format('y-m-d') . ' ';
                }

                $counted = \App\Models\Driver\DriverEmployeeAttendance::groupBy('absence_type')
                    ->select('driver_id', 'absence_type', DB::raw('count(*) as days'), DB::raw('sum(delay_hours) as delay_hours'))
                    ->where('driver_id', $user->id)
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
                // return $note;
                $basic_salary = $user->monthly_salary - $user->monthly_deduct - $user->insurances;
                $hour_salary = $day_salary / 8;
                $final_salary = $basic_salary - ($day_salary * $absence) - ($hour_salary * $delay_hours) - $dayesPriceNotWorked;
                $monthSalaryReport = \App\Models\Driver\DriverEmployeeMonthlySalary::create([
                    'total_salary' => $user->monthly_salary,
                    'basic_salary' => round($basic_salary, 2),
                    'deduction' => round($user->monthly_deduct, 2),
                    'vacation_days' => $vacations,
                    'absence_days' => $absence,
                    'delay_days_hours' => $delay_days,
                    'delay_hours' => $delay_hours,
                    'final_salary' => round($final_salary, 2),
                    'note' => $note,
                    'driver_id' => $user->id,
                ]);
            }

            // Groups expired
            $endDateOfNextMonth = new Carbon('last day of next month');
            $vechilePrice = \App\Models\Groups\GroupVechilePrice::find(1);
            // return $today->hour;
            $firstDateOfMonth = new Carbon('first day of next month');
            $DaysOfMonth = $endDateOfNextMonth->day;
            $daliyPrice = $vechilePrice->vechile_price;
            $groups = Group::where('id', '!=', 1)->get();
            $stakeholder = \App\Models\Nathiraat\Stakeholders::find(8);
            $totalMoney = 0;
            foreach ($groups as $group) {
                $bookingPrice = $group->vechile_counter * $DaysOfMonth * $daliyPrice;
                // return $bookingPrice;
                if ($group->account < $bookingPrice) {
                    // renew booking for next month
                    $group->state = "blocked";
                    $group->save();
                } else {
                    // block group
                    $group->account -= $bookingPrice;
                    $group->renew_date = $endDateOfNextMonth;
                    $group->state = "active";
                    $group->save();
                    GroupBooking::create([
                        // 'added_by' => Auth::guard('admin')->user()->id,
                        'group_id' => $group->id,
                        'vechile_counter' => $group->vechile_counter,
                        'booking_price' => $bookingPrice,
                        'start_date' => $firstDateOfMonth,
                        'end_date' => $endDateOfNextMonth,
                    ]);
                    $boxNathriaat = new \App\Models\Nathiraat\BoxNathriaat;
                    $boxNathriaat->stakeholders_id = 8;
                    $boxNathriaat->foreign_type = 'group';
                    $boxNathriaat->foreign_id = $group->id;
                    $boxNathriaat->bond_type = 'take';
                    $boxNathriaat->payment_type = 'internal transfer';
                    $boxNathriaat->money = $bookingPrice;
                    $boxNathriaat->tax = 0;
                    $boxNathriaat->total_money = $bookingPrice;
                    $boxNathriaat->bond_state = 'deposited';
                    $boxNathriaat->descrpition = 'تجديدالاشتراك للمجموعة : ' . $group->name . ' لنهاية الشهر عدد ايام: ' . $DaysOfMonth . ' سعر الإشتراك: ' . $bookingPrice . ' ريال سعودى';
                    $boxNathriaat->add_date = Carbon::now();
                    // $boxNathriaat->add_by = Auth::guard('admin')->user()->id;
                    $boxNathriaat->save();

                    $totalMoney += $bookingPrice;
                }
            }
            // return $stakeholder;
            $stakeholder->account += $totalMoney;
            $stakeholder->save();
        }
        if ($today->hour === 10) {
            // Contracts that remains only 3 day to end
            $contracts = \App\Models\Contract\Contract::select(['id', 'id_driver', 'contract_end_datetime', 'tenant_mobile', 'tenant_id_number', 'car_plate_number'])
                ->where(DB::raw('date(contract_end_datetime)'), Carbon::now()->addDays(3)->format('y-m-d'))
                ->where('contract_status', 'ساري')
                ->get();

            foreach ($contracts as $contract) {
                $this->send_message($contract->tenant_mobile, 'عزيزي المستأجر صاحب الهوية رقم ' . $contract->tenant_id_number . ' نفيدكم بأنه متبقى ثلاث أيام على انتهاء مدة عقد تأجير السيارة رقم { ' . $contract->car_plate_number . ' } كما أنه إضافة إلى البيانات المالية المحددة في العقد سيتم البدء بإحتساب غرامة التأخير وفقاً للمادة التاسعة من العقد إلى حين تسليم السيارة، علماً بأن التفويض لن يلغى إلى أن تتم عملية التسليم .');
            }

            // Expired Contracts
            $expiredContracts = \App\Models\Contract\Contract::select([
                'id',
                'id_driver',
                'vechile_id',
                'contract_end_datetime',
                'tenant_name_ar',
                'tenant_mobile',
                'lease_cost_dar_hour',
                'main_financial_vat',
                'tenant_id_number',
                'car_plate_number',
            ])
                ->where(DB::raw('date(contract_end_datetime)'), '<', Carbon::now()->format('y-m-d'))
                ->where('contract_status', 'ساري')
                ->get();

            foreach ($expiredContracts as $contract) {
                $driver = \App\Models\Driver::select(['id', 'name', 'phone', 'account'])
                    ->find($contract->id_driver);
                $vechile = \App\Models\Vechile::select(['id', 'plate_number', 'account'])
                    ->find($contract->vechile_id);

                $this->send_message($driver->phone, 'عزيزي المستأجر صاحب الهوية رقم ' . $contract->tenant_id_number . ' نفيدكم بإنتهاء مدة عقد تأجير السيارة رقم { ' . $contract->car_plate_number . ' } كما أنه إضافة إلى البيانات المالية المحددة في العقد سيتم البدء بإحتساب غرامة التأخير وفقاً للمادة التاسعة من العقد إلى حين تسليم السيارة، علماً بأن التفويض لن يلغى إلى أن تتم عملية التسليم .');
                $fine = $contract->lease_cost_dar_hour * 2;
                $totalMoney = $fine + ($fine * $contract->main_financial_vat / 100);
                $boxVechile = new BoxVechile;
                $boxVechile->vechile_id = $vechile->id;
                $boxVechile->foreign_type = 'driver';
                $boxVechile->foreign_id = $driver->id;
                $boxVechile->bond_type = 'take';
                $boxVechile->payment_type = 'internal transfer';
                $boxVechile->bond_state = 'deposited';
                $boxVechile->descrpition = 'غرامة على السائق: ' . $contract->tenant_name_ar . ' لعدم انهاء التعاقد او التمديد لفترة للمركبة ' . $contract->car_plate_number . ' وفقا للمادة التاسعة البند أ.2';
                $boxVechile->money = $fine;
                $boxVechile->tax = $contract->main_financial_vat;
                $boxVechile->total_money = $totalMoney;
                $boxVechile->add_date = Carbon::now();
                $driver->account -= $totalMoney;
                $vechile->account += $totalMoney;
                $boxVechile->save();
                $driver->save();
                $vechile->save();
            }
        }

        $drivers = Driver::select(['id', 'available'])->get();
        foreach ($drivers as $driver) {
            $driver->available = 0;
            $driver->save();
        }


        // $today = new Carbon('2023-1-1 00:00:00');
        $weekStartDate = $today->copy()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d H');
        // $weekEndDate = $today->copy()->endOfWeek()->addDay(6)->format('Y-m-d H:i:s');
        // echo  $weekStartDate ."====". $today->format('Y-m-d H');

        if ($today->format('Y-m-d H') == $weekStartDate) {
            $drivers = \App\Models\Driver::select(['id', 'weekly_amount', 'weekly_remains'])
                ->where('state', 'active')->where('weekly_amount', '>', 0)
                ->get();
            foreach ($drivers as $driver) {
                if ($driver->weekly_remains == 0) {
                    $driver->update([
                        'weekly_remains' => $driver->weekly_amount,
                    ]);
                } else if ($driver->weekly_remains > 0) {
                    $driver->update([
                        'weekly_remains' => $driver->weekly_remains + $driver->weekly_amount,
                    ]);
                }
            }
        }


    }

    public function send_message($phone, $content)
    {
        $now = \Carbon\Carbon::now();
        $token = env('SMS_TOKEN', '');
        $phone = '966' . substr($phone, 1);

        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $token,
        ])->post('https://api.taqnyat.sa/v1/messages', [
            "recipients" => [
                $phone,
            ],
            "body" => $content,
            "sender" => "TaxiAljawab",
            "scheduledDatetime" => $now,
        ]);
        $resp = json_decode($response);

    }

}
