<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Contract\Contract;
use App\Models\Covenant\Covenant;
use App\Models\Covenant\CovenantItem;
use App\Models\Covenant\CovenantRecord;
use App\Models\Driver;
use App\Models\DriverVechile;
use App\Models\Driver\BoxDriver;
use App\Models\Driver\DriverWeeklyDelay;
use App\Models\Driver\DriverNotes;
use App\Models\Nathiraat\Stakeholders;
use App\Models\Vechile;
use App\Models\Vechile\BoxVechile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function show_driver($state = null)
    {
        $drivers;
        $title = 'عرض بيانات السائقين';
        if (Auth::user()->isAbleTo('driver_data') && ($state === 'active' || $state === 'waiting' || $state === 'blocked' || $state === 'pending')) {
            $drivers = DB::select('select driver.id, driver.name, driver.phone , driver.ssd , driver.state,driver.weekly_remains, vechile.vechile_type, vechile.made_in, vechile.plate_number, driver.add_date, admins.name as admin_name,
            ROUND((driver.driver_rate + vechile_rate + time_rate) / (driver_counter+vechile_counter+time_counter) , 1) as rate
            from driver left join vechile on driver.current_vechile = vechile.id left join admins on driver.admin_id = admins.id where driver.state = ?;', [$state]);
            $title = 'عرض بيانات السائقين ال' . $this->driverState($state);
            return view('driver.showDriver', compact('drivers', 'title', 'state'));
        } else if (Auth::user()->isAbleTo('recently_driver') && $state === 'pending') {
            $drivers = DB::select('select driver.id, driver.name, driver.phone , driver.ssd ,driver.state, driver.weekly_remains, vechile.vechile_type, vechile.made_in, vechile.plate_number, driver.add_date, admins.name as admin_name,
            ROUND((driver.driver_rate + vechile_rate + time_rate) / (driver_counter+vechile_counter+time_counter) , 1) as rate
            from driver left join vechile on driver.current_vechile = vechile.id left join admins on driver.admin_id = admins.id where driver.state = ?;', [$state]);
            $title = 'عرض بيانات السائقين ال' . $this->driverState($state);
            return view('driver.showDriver', compact('drivers', 'title', 'state'));
        } else {
            return back();
        }
    }
    public function show_add()
    {
        return view('driver.addDriver');
    }
    public function add_driver(Request $request)
    {
        // return $request->all();

        $request->validate([
            "stakeholder" => 'required|string',
            "name" => 'required|string',
            "nationality" => 'required|string',
            "phone" => 'required|string',
            "address" => 'required|string',

            "ssd" => 'required|string',
            "id_copy_no" => 'required|string',
            "id_expiration_date" => 'required|string',
            "license_type" => 'required|string',
            "license_expiration_date" => 'required|string',
            "birth_date" => 'required|string',
            "start_working_date" => 'required|string',
            "contract_end_date" => 'required|string',
            "final_clearance_date" => 'required|string',
            "id_type" => 'required|string',
            "place_issue" => 'required|string',
            "license_number" => 'required|string',
            "monthly_salary" => "required|numeric",
            "monthly_deduct" => "required|numeric",
            "insurances" => "required|numeric",
            // "basic_salary" => "required|numeric",
            "vacation_days" => "required|integer",
        ]);
        $driverData = Driver::where('ssd', $request->ssd)->orWhere('phone', $request->phone)->get();
        if (count($driverData) > 0) {
            $request->session()->flash('error', 'الرجاء التأكد من البيانات رقم الهوية او الهاتف موجود بالفعل');
            return back();
        } else {
            $driver = new Driver;
            $driver->name = $request->name;
            $driver->password = '0';
            $driver->nationality = $request->nationality;
            $driver->ssd = $request->ssd;
            $driver->address = $request->address;
            $driver->id_copy_no = $request->id_copy_no;
            $driver->id_expiration_date = $request->id_expiration_date;
            $driver->license_type = $request->license_type;
            $driver->license_expiration_date = $request->license_expiration_date;
            $driver->birth_date = $request->birth_date;
            $driver->start_working_date = $request->start_working_date;
            $driver->contract_end_date = $request->contract_end_date;
            $driver->final_clearance_date = $request->final_clearance_date;
            $driver->phone = $request->phone;
            $driver->id_type = $request->id_type;
            $driver->place_issue = $request->place_issue;
            $driver->license_number = $request->license_number;
            $driver->on_company = $request->on_company == null || $request->on_company == false ? 0 : 1;
            $driver->monthly_salary = $request->monthly_salary;
            $driver->monthly_deduct = $request->monthly_deduct;
            $driver->insurances = $request->insurances;
            // $driver->basic_salary = $request->basic_salary;
            $driver->weekly_remains = $request->weekly_amount;
            $driver->weekly_amount  = $request->weekly_amount;

            $driver->vacation_days = $request->vacation_days;
            $driver->vacation_days_remains = $request->vacation_days;

            $driver->admin_id = Auth::guard('admin')->user()->id;
            if ($request->stakeholder != "0") {
                if ($request->stakeholder != "1") {
                    $group = \App\Models\Groups\Group::find($request->stakeholder);
                    if ($group->vechile_counter > $group->added_driver) {
                        $group->added_driver++;
                        $group->save();
                    } else {
                        $request->session()->flash('error', 'لا يمكنك أضافة سائقين فى هذه المجموع مكتملة');
                        return back();
                    }
                }
                $driver->group_id = $request->stakeholder;
            }
            $driver->add_date = Carbon::now();

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time() . '.' . $ext;
                $file->move(public_path('images/drivers/personal_phonto'), $image);
                $driver->persnol_photo = $image;

            }
            $driver->save();
            $request->session()->flash('status', 'تم إضافة السائق بنجاح');
            return back();
        }
    }
    public function chechPermission($driver, $permission)
    {
        if (Auth::guard('admin')->user()->hasPermission($permission)) {
            return true;
        } else {
            if (Auth::guard('admin')->user()->hasPermission('user_group') || Auth::guard('admin')->user()->hasPermission('manage_group')) {
                $group = \App\Models\Groups\Group::where('id', $driver->group_id)->where('state', 'active')->get();
                if (count($group) > 0) {
                    $groupUser = \App\Models\Groups\GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $group[0]->id)->where('state', 'active')->get();
                    if (count($groupUser) > 0) {
                        return true;
                    }
                }
            }

        }
        return false;
    }
    public function detials($id)
    {
        $driver = Driver::select(['id', 'name', 'available', 'nationality', 'ssd',
            'address', 'id_copy_no', 'id_expiration_date', 'license_type',
            'license_expiration_date', 'birth_date', 'start_working_date',
            'contract_end_date', 'final_clearance_date', 'persnol_photo',
            'current_vechile', 'add_date', 'admin_id', 'state', 'email',
            'monthly_deduct', 'insurances', 'monthly_salary', 'vacation_days', 'on_company',
            'email_verified_at', 'phone', 'phone_verified_at', 'id_type',
            'remember_token', 'created_at', 'updated_at',
            'account',
            DB::raw(" ROUND((driver.driver_rate / driver_counter ) , 1) as driver_rate,
            ROUND(( vechile_rate  / vechile_counter) , 1) as vechile_rate,
            ROUND(( time_rate / time_counter) , 1) as time_rate"),
        ])->find($id);
        $vechile = null;
        if ($driver->current_vechile !== null) {
            $vechile = DB::select('select
                                    vechile.id,
                                    vechile.vechile_type,
                                    vechile.made_in,
                                    vechile.serial_number,
                                    vechile.plate_number,
                                    vechile.color,
                                    vechile.driving_license_expiration_date,
                                    vechile.insurance_card_expiration_date,
                                    vechile.periodic_examination_expiration_date,
                                    vechile.operating_card_expiry_date,
                                    vechile.add_date,
                                    vechile.state,
                                    vechile.daily_revenue_cost,
                                    vechile.maintenance_revenue_cost,
                                    vechile.identity_revenue_cost,
                                    driver.name,
                                    driver.phone,
                                    admins.name as admin_name,
                                    category.category_name,
                                    secondary_category.name
                                    from vechile left join category on vechile.category_id = category.id
                                    left join driver on vechile.id = driver.current_vechile
                                    left join admins on vechile.admin_id = admins.id
                                    left join secondary_category on vechile.secondary_id = secondary_category.id  where vechile.id = ? limit 1;', [$driver->current_vechile]);
            $vechile = $vechile[0];
        }

        return view('driver.detials', compact('driver', 'vechile'));
    }

    public function update_show($id)
    {
        $driver = Driver::find($id);
        if ($driver !== null) {
            $level = $this->chechPermission($driver, 'driver_update_data');
            if ($level == true) {
                return view('driver.updateDriver', compact('driver'));
            } else {
                session()->flash('status', 'ليس لديك صلاحيات');
            }

        }

        return back();
    }
    public function update_driver(Request $request)
    {
        // return $request->all();

        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'nationality' => 'required',
            'ssd' => 'required',
            'address' => 'required',
            'id_expiration_date' => 'required',
            'license_type' => 'required',
            'license_expiration_date' => 'required',
            'birth_date' => 'required',
            'start_working_date' => 'required',
            'contract_end_date' => 'required',
            'final_clearance_date' => 'required',
            'phone' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "id_type" => 'required|string',
            "place_issue" => 'required|string',
            "license_number" => 'required|string',
            // "monthly_salary" => "required|numeric",
            "weekly_amount" => "required|numeric",
            "monthly_deduct" => "required|numeric",
            "insurances" => "required|numeric",
            "basic_salary" => "required|numeric",
            "vacation_days" => "required|integer",
        ]);

        $driverData = DB::select("select id from driver where id != ? and ( ssd = ? or phone = ?)", [$request->id, $request->ssd, $request->phone]);
        if (count($driverData) > 0) {
            $request->session()->flash('error', 'الرجاء التأكد من البيانات رقم الهوية او الهاتف موجود بالفعل');
            return back();
        }
        $driver = Driver::find($request->id);

        if ($driver !== null) {
            // $drv = DB::select('select id from driver where id != ? and (phone = ? )', [$request->id,$request->phone]);
            // if(count($drv) > 0){
            //     $request->session()->flash('error', 'رقم الهاتف موجود بالفعل');
            //     return back();
            // }
            $note = '';
            if ($driver->name != $request->name) {
                $note .= ' تم تغيير الاسم من ' . ($driver->name == null ? ' فارغ ' : $driver->name) . '  الي ' . $request->name;

            }
            $driver->name = $request->name;

            if ($driver->nationality != $request->nationality) {
                $note .= ' تم تغيير الجنسية من ' . ($driver->nationality == null ? ' فارغ ' : $driver->nationality) . ' الي ' . $request->nationality;

            }
            $driver->nationality = $request->nationality;
            if ($driver->address != $request->address) {
                $note .= ' تم تغيير العنوان من  ' . ($driver->address == null ? ' فارغ ' : $driver->address) . ' الي ' . $request->address;

            }
            $driver->address = $request->address;
            if ($driver->ssd != $request->ssd) {
                $note .= ' تم تغيير الهوية من  ' . ($driver->ssd == null ? ' فارغ ' : $driver->ssd) . ' الي ' . $request->ssd;

            }

            $driver->ssd = $request->ssd;

            if (date('Y-m-d', strtotime($driver->id_expiration_date)) != date('Y-m-d', strtotime($request->id_expiration_date))) {
                $note .= ' تم تغيير تاريخ انتهاء الهوية من ' . ($driver->id_expiration_date == null ? ' فارغ ' : $driver->id_expiration_date) . ' الي ' . $request->id_expiration_date;

            }

            $driver->id_expiration_date = $request->id_expiration_date;
            if ($driver->license_type != $request->license_type) {
                $note .= ' تم تغيير نوع الرخصة  من  ' . ($driver->license_type == null ? ' فارغ ' : $driver->license_type) . ' الي ' . $request->license_type;

            }
            $driver->license_type = $request->license_type;
            if (date('Y-m-d', strtotime($driver->license_expiration_date)) != date('Y-m-d', strtotime($request->license_expiration_date))) {
                $note .= ' تم تغيير   تاريخ انتهاء الرخصة  من  ' . ($driver->license_expiration_date == null ? ' فارغ ' : $driver->license_expiration_date) . ' الي ' . $request->license_expiration_date;

            }
            $driver->license_expiration_date = $request->license_expiration_date;
            if (date('Y-m-d', strtotime($driver->birth_date)) != date('Y-m-d', strtotime($request->birth_date))) {
                $note .= ' تم تغيير   تاريخ  الميلاد  من  ' . ($driver->birth_date == null ? ' فارغ ' : $driver->birth_date) . ' الي ' . $request->birth_date;

            }
            $driver->birth_date = $request->birth_date;
            if (date('Y-m-d', strtotime($driver->start_working_date)) != date('Y-m-d', strtotime($request->start_working_date))) {
                $note .= ' تم تغيير   تاريخ  بدأ العمل  من  ' . ($driver->start_working_date == null ? ' فارغ ' : $driver->start_working_date) . ' الي ' . $request->start_working_date;

            }
            $driver->start_working_date = $request->start_working_date;
            if (date('Y-m-d', strtotime($driver->contract_end_date)) != date('Y-m-d', strtotime($request->contract_end_date))) {
                $note .= ' تم تغيير   تاريخ  نهاية العقد  من  ' . ($driver->contract_end_date == null ? ' فارغ ' : $driver->contract_end_date) . ' الي ' . $request->contract_end_date;

            }
            $driver->contract_end_date = $request->contract_end_date;
            if (date('Y-m-d', strtotime($driver->final_clearance_date)) != date('Y-m-d', strtotime($request->final_clearance_date))) {
                $note .= ' تم تغيير   تاريخ   المخالصة النهائيه  من  ' . ($driver->final_clearance_date == null ? ' فارغ ' : $driver->final_clearance_date) . ' الي ' . $request->final_clearance_date;

            }
            $driver->final_clearance_date = $request->final_clearance_date;
            if ($driver->phone != $request->phone) {
                $note .= ' تم تغيير  رقم الجوال  من  ' . ($driver->phone == null ? ' فارغ ' : $driver->phone) . ' الي ' . $request->phone;

            }
            $driver->phone = $request->phone;
            if ($driver->id_type != $request->id_type) {
                $note .= ' تم تغيير   نوع الهوية  من  ' . ($driver->id_type == null ? ' فارغ ' : $driver->id_type) . ' الي ' . $request->id_type;

            }
            $driver->id_type = $request->id_type;
            if ($driver->place_issue != $request->place_issue) {
                $note .= ' تم تغيير  مكان اصدار الهوية  من  ' . ($driver->place_issue == null ? ' فارغ ' : $driver->place_issue) . ' الي ' . $request->place_issue;

            }
            $driver->place_issue = $request->place_issue;
            if ($driver->license_number != $request->license_number) {
                $note .= ' تم تغيير رقم الرخصة  من  ' . ($driver->license_number == null ? ' فارغ ' : $driver->license_number) . ' الي ' . $request->license_number;

            }
            $driver->license_number = $request->license_number;

            if ($driver->on_company != $request->on_company) {
                if ($driver->on_company == null || $driver->on_company == 0) {

                    $note .= 'تم تغير اقامة السائق من غير مسجل على كفالة الشركة إلى مسجل على كفالة الشركة';
                } else {

                    $note .= 'تم تغير اقامة السائق من مسجل على كفالة الشركة إلى غير مسجل على كفالة الشركة';
                }

            }
            $driver->on_company = $request->on_company == null || $request->on_company == false ? 0 : 1;

            if ($driver->monthly_salary != $request->monthly_salary) {
                $note .= ' تم تغيير الراتب الشهرى من  ' . ($driver->monthly_salary == null ? ' فارغ ' : $driver->monthly_salary) . ' الي ' . $request->monthly_salary;
            }
            $driver->monthly_salary = $request->monthly_salary;

            if ($driver->monthly_deduct != $request->monthly_deduct) {
                $note .= 'تم تغير قيمة الاستقطاع الشهرى من:'. ($driver->monthly_deduct == null ? ' فارغ ' : $driver->monthly_deduct) . ' الي ' . $request->monthly_deduct;
            }
            $driver->monthly_deduct = $request->monthly_deduct;

            if ($driver->insurances != $request->insurances) {
                $note .= ' تم تغيير التأمينات من  ' . ($driver->insurances == null ? ' فارغ ' : $driver->insurances) . ' الي ' . $request->insurances;
            }
            $driver->insurances = $request->insurances;
            // $driver->basic_salary = $request->basic_salary;

            if ($driver->vacation_days != $request->vacation_days) {
                $note .= ' تم تغيير ايام الاجازة السنوية من  ' . ($driver->vacation_days == null ? ' فارغ ' : $driver->vacation_days) . ' الي ' . $request->vacation_days;
            }
            $driver->vacation_days = $request->vacation_days;

            if ($driver->weekly_amount != $request->weekly_amount) {
                $now = Carbon::now();
                // $now = new Carbon('2023-1-2 00:00:00');
                $weekStartDate = $now->copy()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d H:i:s');
                $weekEndDate = $now->copy()->endOfWeek(Carbon::SATURDAY)->format('Y-m-d H:i:s');
                $weeklyDelay = \App\Models\Driver\DriverWeeklyDelay::where('driver_id', $driver->id)
                                ->where('start_week' , $weekStartDate)
                                ->where('end_week' , $weekEndDate)
                                ->orderBy('start_week', 'desc')->first();
                // echo  $weekStartDate ."====". $weekEndDate;
                // return $driver;
                // return $weeklyDelay;
                $updateDiff = $request->weekly_amount - $driver->weekly_amount;
                if($weeklyDelay !== null){
                    $weeklyDelay->update([
                        'weekly_money_due' => $request->weekly_amount,
                        'remains' => ($driver->weekly_remains + $updateDiff) > 0 ? ($driver->weekly_remains + $updateDiff) : 0,
                        'added_by' => auth()->id(),
                    ]);
                    // $driver->weekly_remains = $updateDiff > 0 ? $request->weekly_amount : $driver->weekly_amount;
                }
                $weekly_remains = ($driver->weekly_remains + $updateDiff) > 0 ? ($driver->weekly_remains + $updateDiff) : 0;
                $driver->weekly_remains = $weekly_remains;
                $note .= ' تم تغيير الدفع الأسبوع المستحق من  ' . ($driver->weekly_amount == null ? ' فارغ ' : $driver->weekly_amount) . ' الي ' . $request->weekly_amount;
            }
            $driver->weekly_amount = $request->weekly_amount;

            $driver->admin_id = Auth::guard('admin')->user()->id;
            if ($request->stakeholder != "0") {
                if ($request->stakeholder != "1") {
                    $group = \App\Models\Groups\Group::find($request->stakeholder);
                    if ($group->vechile_counter > $group->added_driver) {

                        $group->added_driver++;
                        $group->save();
                    } else {
                        $request->session()->flash('error', 'لا يمكنك أضافة سائقين فى هذه المجموع مكتملة');
                        return back();
                    }
                }
                if ($driver->group_id != $request->stakeholder) {
                    if ($driver->group_id == null || $driver->group_id == '0') {
                        $note .= ' تم تغيير المجموعة من شركة الجواب الي  مجموعة رقم ' .$request->stakeholder;
                    } else {

                    }
                }
                $driver->group_id = $request->stakeholder;
            }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = $file->getClientOriginalName();
                $ext = $file->getClientOriginalExtension();
                $size = $file->getSize();
                $mim = $file->getMimeType();
                $realpath = $file->getRealPath();
                $image = time() . '.' . $ext;
                $file->move(public_path('images/drivers/personal_phonto'), $image);
                $driver->persnol_photo = $image;
                $note .= ' تم تغيير  الصورة ';

            }
            if ($note != "") {
                $not = new DriverNotes;
                $not->note_type = "تعديل بيانات";
                $not->content = $note;
                $not->add_date = Carbon::now();
                $not->admin_id = Auth::guard('admin')->user()->id;
                $not->driver_id = $driver->id;

                $not->save();
            }
            $driver->save();
            $request->session()->flash('status', 'تم تعديل السائق بنجاح');
            return back();
        } else {
            $request->session()->flash('error', 'خطاء فى البيانات المدخلة');
            return back();
        }
    }
    public function vechiles($id)
    {
        $vechiles = DB::select('select vechile.vechile_type, vechile.plate_number, vechile.made_in, start_date_drive, end_date_drive, reason
        from driver, vechile,  driver_vechile where driver.id=driver_vechile.driver_id and vechile.id= driver_vechile.vechile_id and  driver.id = ?;', [$id]);
        return view('driver.vechilesForDriver', compact('vechiles'));
    }
    public function show_state($id)
    {
        $covenants = DB::select('select covenant_items.id, covenant_items.covenant_name,
        covenant_items.serial_number, covenant_items.state , covenant_items.delivery_date
        from covenant_items where current_driver = ?', [$id]);
        return view('driver.stateDriver', compact('id', 'covenants'));

    }
    public function save_state(Request $request)
    {
        /*
        // return Auth::guard('admin')->user()->hasPermission('user_delivery_covenant');
        $userCovenants =  CovenantRecord::where('forign_type', 'user')
        ->where('receive_by', null)->where('receive_date', null)->orderBy('delivery_date', 'desc')->get();
        if(count($userCovenants) == 0){
        $request->session()->flash('error', 'خطاء لا يوجد مستخدم مستلم العهد  ');
        return back();
        }
        else if($userCovenants[0]->forign_id !== Auth::guard('admin')->user()->id){
        $request->session()->flash('error', 'يجب ان يكون مستخدم مستلم العهدة هو من يقوم بتسلم العهد ');
        return back();
        }
         */
        $driver = Driver::find($request->id);
        if ($request->has('item')) {
            $covenantitems = CovenantItem::whereIn('id', $request->item)->get();

            if ($driver != null) {

                CovenantRecord::where('forign_type', 'driver')
                    ->where('forign_id', $request->id)
                    ->where('receive_date', null)->orderBy('delivery_date', 'desc')
                    ->update(['receive_date' => Carbon::now(), 'receive_by' => Auth::guard('admin')->user()->id]);

                foreach ($covenantitems as $item) {

                    $cov = Covenant::where('covenant_name', $item->covenant_name)->first();
                    if ($cov != null) {
                        if ($cov->delivered_user != null) {
                            $covenantRecord = new CovenantRecord();
                            $covenantRecord->forign_type = 'user';
                            $covenantRecord->forign_id = $cov->delivered_user;
                            $covenantRecord->item_id = $item->id;
                            $covenantRecord->delivery_date = Carbon::now();
                            $covenantRecord->delivery_by = Auth::guard('admin')->user()->id;
                            $covenantRecord->save();
                        }
                    }
                    $item->current_driver = null;
                    $item->state = 'waiting';
                    $item->delivery_date = null;
                    $item->save();
                }

            }
        }
        if ($driver !== null) {
            //check if driver has vechile now
            $prefVechile = Vechile::find($driver->current_vechile);
            $maintenance = Stakeholders::find(9);
            $identity = Stakeholders::find(10);
            $totalMoneyAddForDriver = 0;
            if ($prefVechile) {
                //change vechile state and the time campany back vechile
                $prefVechile->state = 'waiting';
                $prefDriverVechile = DriverVechile::where('vechile_id', $prefVechile->id)->where('driver_id', $driver->id)->where('end_date_drive', null)->where('reason', null)->orderBy('start_date_drive', 'desc')
                    ->limit(1)->get();

                if (count($prefDriverVechile) > 0) {
                    //$dailyCost = DB::select("select category.daily_revenue_cost from vechile, category where vechile.category_id = category.id and vechile.id = ? and (category.percentage_type ='daily' or category.percentage_type = 'daily_percent') limit 1;", [$prefVechile->id]);

                    $daysDriverHasVechile = $prefDriverVechile[0]->start_date_drive->diffInDays(Carbon::now()->addDay());
                    $payedRegister = $prefDriverVechile[0]->payedRegister;
                    $daysNotRegister = $daysDriverHasVechile - $payedRegister;
                    $prefDriverVechile[0]->payedRegister = $daysDriverHasVechile;

                    if ($daysNotRegister > 0) {
                        $addMoney = $prefVechile->daily_revenue_cost * $daysNotRegister;
                        if ($addMoney > 0) {
                            $boxVechile = new BoxVechile;
                            $boxVechile->vechile_id = $prefVechile->id;
                            $boxVechile->foreign_type = 'driver';
                            $boxVechile->foreign_id = $driver->id;
                            $boxVechile->bond_type = 'take';
                            $boxVechile->payment_type = 'internal transfer';
                            $boxVechile->money = $addMoney;
                            $boxVechile->tax = 0;
                            $boxVechile->total_money = $addMoney;
                            $boxVechile->bond_state = 'deposited';
                            $boxVechile->descrpition = 'ايام لم يتم تسجلها بشكل يومي عائد يومى للمركبة عدد الايام ' . $daysNotRegister . 'المبالغ المضاف : ' . $addMoney;
                            $boxVechile->add_date = Carbon::now();
                            $totalMoneyAddForDriver += $addMoney;

                            $prefVechile->account = $prefVechile->account + ($addMoney);
                            $boxVechile->save();
                        }
                        $maintenance_revenue_cost = $prefVechile->maintenance_revenue_cost * $daysNotRegister;
                        if ($maintenance_revenue_cost > 0) {
                            $boxDriver = new BoxDriver;
                            $boxDriver->driver_id = $driver->id;
                            $boxDriver->foreign_type = 'stakeholders';
                            $boxDriver->foreign_id = $maintenance->id;
                            $boxDriver->bond_type = 'spend';
                            $boxDriver->payment_type = 'internal transfer';
                            $boxDriver->bond_state = 'deposited';
                            $boxDriver->descrpition = 'ايام لم يتم تسجلها بشكل يومي عائد يومى لصيانة المركبة عدد الايام  ' . $daysNotRegister . 'المبالغ المضاف : ' . $maintenance_revenue_cost;
                            $boxDriver->money = $maintenance_revenue_cost;
                            $boxDriver->tax = 0;
                            $boxDriver->total_money = $maintenance_revenue_cost;
                            $boxDriver->add_date = Carbon::now();
                            $maintenance->account += $maintenance_revenue_cost;
                            $maintenance->save();
                            $totalMoneyAddForDriver += $maintenance_revenue_cost;
                            $boxDriver->save();
                        }

                        $identity_revenue_cost = $prefVechile->identity_revenue_cost * $daysNotRegister;
                        if ($identity_revenue_cost > 0) {
                            $boxDriver = new BoxDriver;
                            $boxDriver->driver_id = $driver->id;
                            $boxDriver->foreign_type = 'stakeholders';
                            $boxDriver->foreign_id = $identity->id;
                            $boxDriver->bond_type = 'spend';
                            $boxDriver->payment_type = 'internal transfer';
                            $boxDriver->bond_state = 'deposited';
                            $boxDriver->descrpition = 'ايام لم يتم تسجلها بشكل يومي عائد يومى للتجديد الإقامة عدد الايام  ' . $daysNotRegister . 'المبالغ المضاف : ' . $identity_revenue_cost;
                            $boxDriver->money = $identity_revenue_cost;
                            $boxDriver->tax = 0;
                            $boxDriver->total_money = $identity_revenue_cost;
                            $boxDriver->add_date = Carbon::now();
                            $totalMoneyAddForDriver += $identity_revenue_cost;
                            $identity->account += $identity_revenue_cost;
                            $identity->save();
                            $boxDriver->save();
                        }
                    }

                    $prefDriverVechile[0]->end_date_drive = Carbon::now();
                    $prefDriverVechile[0]->admin_id = Auth::guard('admin')->user()->id;
                    $prefDriverVechile[0]->reason = 'تغير حالة السائق من' . $driver->state . 'الى' . $request->state;
                    $prefDriverVechile[0]->save();
                }
                $prefVechile->save();
            }
            $note = new DriverNotes;
            $note->driver_id = $request->id;
            $note->admin_id = Auth::guard('admin')->user()->id;
            $note->add_date = Carbon::now();

            $note->note_type = ' تغير حالة السائق من ' . $this->getState($driver->state) . '  الى  ' . $this->getState($request->state);
            $driver->state = $request->state;
            $driver->current_vechile = null;
            $driver->account -= $totalMoneyAddForDriver;
            $note->content = $request->reason;
            $driver->save();
            $note->save();
            $request->session()->flash('status', 'تم تغير حالة السائق بنجاح');
            if (Auth::guard('admin')->user()->hasPermission('driver_data_show')) {
                return redirect('driver/details/' . $request->id);
            } else {
                return back();
            }

        } else {
            $request->session()->flash('error', 'خطاء فى البيانات المدخلة');
            return back();
        }

    }
    public function getState($state)
    {
        if ($state == 'active') {
            return 'مستلم';
        } else if ($state == 'blocked') {
            return 'مستبعد';
        } else if ($state == 'waiting') {
            return 'انتظار';
        } else if ($state == 'pending') {
            return 'انتظار الموافقة';
        } else {
            return ' ';
        }

    }
    public function save_state1(Request $request)
    {

        if ($request->has('item')) {
            $covenantitems = CovenantItem::whereIn('id', $request->item)->get();

            $driver = Driver::find($request->id);
            if ($driver != null) {

                CovenantRecord::where('forign_type', 'driver')
                    ->where('forign_id', $request->id)
                    ->where('receive_date', null)->orderBy('delivery_date', 'desc')
                    ->update(['receive_date' => Carbon::now(), 'receive_by' => Auth::guard('admin')->user()->id]);

                foreach ($covenantitems as $item) {

                    $cov = Covenant::where('covenant_name', $item->covenant_name)->first();
                    if ($cov != null) {
                        if ($cov->delivered_user != null) {
                            $covenantRecord = new CovenantRecord();
                            $covenantRecord->forign_type = 'user';
                            $covenantRecord->forign_id = $cov->delivered_user;
                            $covenantRecord->item_id = $item->id;
                            $covenantRecord->delivery_date = Carbon::now();
                            $covenantRecord->delivery_by = Auth::guard('admin')->user()->id;
                            $covenantRecord->save();
                        }
                    }

                }

            }
        }

        if ($driver !== null) {
            //check if driver has vechile now
            $prefVechile = Vechile::find($driver->current_vechile);
            $maintenance = Stakeholders::find(9);
            $identity = Stakeholders::find(10);
            $totalMoneyAddForDriver = 0;
            if ($prefVechile) {
                //change vechile state and the time campany back vechile
                $prefVechile->state = 'waiting';
                $prefDriverVechile = DriverVechile::where('vechile_id', $prefVechile->id)->where('driver_id', $driver->id)->where('end_date_drive', null)->where('reason', null)->orderBy('start_date_drive', 'desc')
                    ->limit(1)->get();

                if (count($prefDriverVechile) > 0) {
                    //$dailyCost = DB::select("select category.daily_revenue_cost from vechile, category where vechile.category_id = category.id and vechile.id = ? and (category.percentage_type ='daily' or category.percentage_type = 'daily_percent') limit 1;", [$prefVechile->id]);

                    $daysDriverHasVechile = $prefDriverVechile[0]->start_date_drive->diffInDays(Carbon::now()->addDay());
                    $payedRegister = $prefDriverVechile[0]->payedRegister;
                    $daysNotRegister = $daysDriverHasVechile - $payedRegister;
                    $prefDriverVechile[0]->payedRegister = $daysDriverHasVechile;

                    if ($daysNotRegister > 0) {
                        $addMoney = $prefVechile->daily_revenue_cost * $daysNotRegister;
                        if ($addMoney > 0) {
                            $boxVechile = new BoxVechile;
                            $boxVechile->vechile_id = $prefVechile->id;
                            $boxVechile->foreign_type = 'driver';
                            $boxVechile->foreign_id = $driver->id;
                            $boxVechile->bond_type = 'take';
                            $boxVechile->payment_type = 'internal transfer';
                            $boxVechile->money = $addMoney;
                            $boxVechile->tax = 0;
                            $boxVechile->total_money = $addMoney;
                            $boxVechile->bond_state = 'deposited';
                            $boxVechile->descrpition = 'ايام لم يتم تسجلها بشكل يومي عائد يومى للمركبة عدد الايام ' . $daysNotRegister . 'المبالغ المضاف : ' . $addMoney;
                            $boxVechile->add_date = Carbon::now();
                            $totalMoneyAddForDriver += $addMoney;

                            $prefVechile->account = $prefVechile->account + ($addMoney);
                            $boxVechile->save();
                        }
                        $maintenance_revenue_cost = $prefVechile->maintenance_revenue_cost * $daysNotRegister;
                        if ($maintenance_revenue_cost > 0) {
                            $boxDriver = new BoxDriver;
                            $boxDriver->driver_id = $driver->id;
                            $boxDriver->foreign_type = 'stakeholders';
                            $boxDriver->foreign_id = $maintenance->id;
                            $boxDriver->bond_type = 'spend';
                            $boxDriver->payment_type = 'internal transfer';
                            $boxDriver->bond_state = 'deposited';
                            $boxDriver->descrpition = 'ايام لم يتم تسجلها بشكل يومي عائد يومى لصيانة المركبة عدد الايام  ' . $daysNotRegister . 'المبالغ المضاف : ' . $maintenance_revenue_cost;
                            $boxDriver->money = $maintenance_revenue_cost;
                            $boxDriver->tax = 0;
                            $boxDriver->total_money = $maintenance_revenue_cost;
                            $boxDriver->add_date = Carbon::now();
                            $maintenance->account += $maintenance_revenue_cost;
                            $maintenance->save();
                            $totalMoneyAddForDriver += $maintenance_revenue_cost;
                            $boxDriver->save();
                        }

                        $identity_revenue_cost = $prefVechile->identity_revenue_cost * $daysNotRegister;
                        if ($identity_revenue_cost > 0) {
                            $boxDriver = new BoxDriver;
                            $boxDriver->driver_id = $driver->id;
                            $boxDriver->foreign_type = 'stakeholders';
                            $boxDriver->foreign_id = $identity->id;
                            $boxDriver->bond_type = 'spend';
                            $boxDriver->payment_type = 'internal transfer';
                            $boxDriver->bond_state = 'deposited';
                            $boxDriver->descrpition = 'ايام لم يتم تسجلها بشكل يومي عائد يومى للتجديد الإقامة عدد الايام  ' . $daysNotRegister . 'المبالغ المضاف : ' . $identity_revenue_cost;
                            $boxDriver->money = $identity_revenue_cost;
                            $boxDriver->tax = 0;
                            $boxDriver->total_money = $identity_revenue_cost;
                            $boxDriver->add_date = Carbon::now();
                            $totalMoneyAddForDriver += $identity_revenue_cost;
                            $identity->account += $identity_revenue_cost;
                            $identity->save();
                            $boxDriver->save();
                        }
                    }

                    $prefDriverVechile[0]->end_date_drive = Carbon::now();
                    $prefDriverVechile[0]->admin_id = Auth::guard('admin')->user()->id;
                    $prefDriverVechile[0]->reason = 'تغير حالة السائق من' . $driver->state . 'الى' . $request->state;
                    $prefDriverVechile[0]->save();
                }
                $prefVechile->save();
            }
            $note = new DriverNotes;
            $note->driver_id = $request->id;
            $note->admin_id = Auth::guard('admin')->user()->id;
            $note->add_date = Carbon::now();
            $note->note_type = 'تغير حالة السائق من' . $driver->state . 'الى' . $request->state;
            $driver->state = $request->state;
            $driver->current_vechile = null;
            $driver->account -= $totalMoneyAddForDriver;
            $note->content = $request->reason;
            $driver->save();
            $note->save();
            $request->session()->flash('status', 'تم تغير حالة السائق بنجاح');

            return redirect('driver/details/' . $request->id);

        } else {
            $request->session()->flash('error', 'خطاء فى البيانات المدخلة');
            return back();
        }

    }

    public function show_take($id)
    {
        $waitingVechiles = Vechile::select(['id', 'vechile_type', 'made_in', 'plate_number', 'color'])->where('state', 'waiting')->get();
        $driver = Driver::find($id);
        if ($driver->state === 'active') {
            session()->flash('error', 'يجب تسلم المركبة اولا وتحويل حالة السائق انتظار');
            return back();
        }
        if (count($waitingVechiles) > 0 && $driver !== null) {
            $allCovenant = \App\Models\Covenant\Covenant::all();

            return view('driver.takeVechile', compact('waitingVechiles', 'driver', 'allCovenant'));
        } else {
            session()->flash('error', 'لا يوجد مركبات متاحة الأن');
            return back();
        }

    }
    public function save_take(Request $request)
    {
        $request->validate([
            'driver_id' => 'required|integer',
            'vechile_id' => 'required|integer',
            'daily_revenue_cost' => 'required|numeric',
            'maintenance_revenue_cost' => 'required|numeric',
            'identity_revenue_cost' => 'required|numeric',
        ]);
        // return $request->all();
        $userCovenants = CovenantRecord::where('forign_type', 'user')
            ->where('receive_by', null)->where('receive_date', null)->orderBy('delivery_date', 'desc')->get();
        if (count($userCovenants) == 0) {
            $request->session()->flash('error', 'خطاء لا يوجد مستخدم مستلم العهد  ');
            return back();
        }
        // else if($userCovenants[0]->forign_id !== Auth::guard('admin')->user()->id){
        //     $request->session()->flash('error', 'يجب ان يكون مستخدم مستلم العهدة هو من يقوم بتسليم العهد ');
        //     return back();
        // }
        if ($request->has('covenant_item')) {
            foreach ($request->covenant_item as $item) {
                $prevUserReceive = CovenantRecord::where('item_id', $item)
                    ->where('forign_type', 'user')
                    ->where('receive_date', null)->get();
                $adminDelivery = count($prevUserReceive) > 0 ? $prevUserReceive[0] : null;

                if ($adminDelivery !== null) {
                    $adminDelivery->receive_date = Carbon::now();
                    $adminDelivery->receive_by = Auth::guard('admin')->user()->id;
                    $adminDelivery->save();
                }
                $covenantItem = CovenantItem::find($item);
                if ($covenantItem !== null) {
                    $covenantItem->current_driver = $request->driver_id;
                    $covenantItem->state = 'active';
                    $covenantItem->delivery_date = Carbon::now();

                    $covenantRecord = new CovenantRecord;
                    $covenantRecord->forign_type = 'driver';
                    $covenantRecord->forign_id = $request->driver_id;
                    $covenantRecord->item_id = $item;
                    $covenantRecord->delivery_date = Carbon::now();
                    $covenantRecord->delivery_by = Auth::guard('admin')->user()->id;

                    $covenantItem->save();
                    $covenantRecord->save();

                    $request->session()->flash('status', 'تم تسليم العهد للسائق  نجاح');
                }
            }
        }

        $driver = Driver::find($request->driver_id);

        if ($driver === null) {
            $request->session()->flash('error', 'خطاء فى البيانات المدخلة');
            return back();
        }

        $totalMoneyAddForDriver = 0;
        $maintenance = Stakeholders::find(9);
        $identity = Stakeholders::find(10);
        //check if driver has vechile now
        $prefVechile = Vechile::find($driver->current_vechile);
        if ($prefVechile !== null) {
            //change vechile state and the time campany back vechile
            $prefVechile->state = 'waiting';
            $prefDriverVechile = DriverVechile::where('vechile_id', $prefVechile->id)->where('driver_id', $driver->id)->where('end_date_drive', null)->where('reason', null)->orderBy('start_date_drive', 'desc')
                ->limit(1)->get();

            if (count($prefDriverVechile) > 0) {
                //$dailyCost = DB::select("select category.daily_revenue_cost from vechile, category where vechile.category_id = category.id and vechile.id = ? and (category.percentage_type ='daily' or category.percentage_type = 'daily_percent') limit 1;", [$prefVechile->id]);
                $daysDriverHasVechile = $prefDriverVechile[0]->start_date_drive->diffInDays(Carbon::now()->addDay());
                $payedRegister = $prefDriverVechile[0]->payedRegister;
                $daysNotRegister = $daysDriverHasVechile - $payedRegister;
                $prefDriverVechile[0]->payedRegister = $daysDriverHasVechile;

                // $maintenance_revenue_cost = $request->maintenance_revenue_cost * $daysNotRegister;
                // return $prefVechile;
                if ($daysNotRegister > 0) {
                    $addMoney = $prefVechile->daily_revenue_cost * $daysNotRegister;
                    if ($addMoney > 0) {
                        $boxVechile = new BoxVechile;
                        $boxVechile->vechile_id = $prefVechile->id;
                        $boxVechile->foreign_type = 'driver';
                        $boxVechile->foreign_id = $driver->id;
                        $boxVechile->bond_type = 'take';
                        $boxVechile->payment_type = 'internal transfer';
                        $boxVechile->money = $addMoney;
                        $boxVechile->tax = 0;
                        $boxVechile->total_money = $addMoney;
                        $boxVechile->bond_state = 'deposited';
                        $boxVechile->descrpition = 'ايام لم يتم تسجلها بشكل يومي عائد يومى للمركبة عدد الايام ' . $daysNotRegister . 'المبالغ المضاف : ' . $addMoney;
                        $boxVechile->add_date = Carbon::now();
                        $boxVechile->save();

                        $totalMoneyAddForDriver += $addMoney;
                        $prefVechile->account = $prefVechile->account + ($addMoney);
                    }

                    $maintenance_revenue_cost = $prefVechile->maintenance_revenue_cost * $daysNotRegister;
                    if ($maintenance_revenue_cost > 0) {
                        $boxDriver = new BoxDriver;
                        $boxDriver->driver_id = $driver->id;
                        $boxDriver->foreign_type = 'stakeholders';
                        $boxDriver->foreign_id = $maintenance->id;
                        $boxDriver->bond_type = 'spend';
                        $boxDriver->payment_type = 'internal transfer';
                        $boxDriver->bond_state = 'deposited';
                        $boxDriver->descrpition = 'ايام لم يتم تسجلها بشكل يومي عائد يومى لصيانة المركبة عدد الايام  ' . $daysNotRegister . 'المبالغ المضاف : ' . $maintenance_revenue_cost;
                        $boxDriver->money = $maintenance_revenue_cost;
                        $boxDriver->tax = 0;
                        $boxDriver->total_money = $maintenance_revenue_cost;
                        $boxDriver->add_date = Carbon::now();

                        $maintenance->account += $maintenance_revenue_cost;
                        $maintenance->save();
                        $totalMoneyAddForDriver += $maintenance_revenue_cost;
                        $boxDriver->save();
                    }

                    $identity_revenue_cost = $prefVechile->identity_revenue_cost * $daysNotRegister;
                    if ($identity_revenue_cost > 0) {
                        $boxDriver = new BoxDriver;
                        $boxDriver->driver_id = $driver->id;
                        $boxDriver->foreign_type = 'stakeholders';
                        $boxDriver->foreign_id = $identity->id;
                        $boxDriver->bond_type = 'spend';
                        $boxDriver->payment_type = 'internal transfer';
                        $boxDriver->bond_state = 'deposited';
                        $boxDriver->descrpition = 'ايام لم يتم تسجلها بشكل يومي عائد يومى للتجديد الإقامة عدد الايام  ' . $daysNotRegister . 'المبالغ المضاف : ' . $identity_revenue_cost;
                        $boxDriver->money = $identity_revenue_cost;
                        $boxDriver->tax = 0;
                        $boxDriver->total_money = $identity_revenue_cost;
                        $boxDriver->add_date = Carbon::now();

                        $totalMoneyAddForDriver += $identity_revenue_cost;

                        $identity->account += $identity_revenue_cost;
                        $identity->save();
                        $boxDriver->save();
                    }

                }

                $prefDriverVechile[0]->end_date_drive = Carbon::now();
                $prefDriverVechile[0]->admin_id = Auth::guard('admin')->user()->id;
                $prefDriverVechile[0]->reason = 'تغير السيارة و استلام سيارة اخرى';
                $prefDriverVechile[0]->save();
            }

            $prefVechile->save();
        }
        $vechile = Vechile::find($request->vechile_id);
        if ($vechile !== null) {

            $driverVechile1 = new DriverVechile;
            $driverVechile1->vechile_id = $vechile->id;
            $driverVechile1->driver_id = $driver->id;
            $driverVechile1->start_date_drive = Carbon::now();
            $driverVechile1->payedRegister = 1;
            $driverVechile1->admin_id = Auth::guard('admin')->user()->id;
            $driverVechile1->save();

            $vechile->state = 'active';
            $vechile->save();
            $driver->account -= $totalMoneyAddForDriver;
            $driver->state = 'active';
            $driver->current_vechile = $vechile->id;

            //$dailyCost = DB::select("select category.daily_revenue_cost from vechile, category where vechile.category_id = category.id and vechile.id = ? and (category.percentage_type ='daily' or category.percentage_type = 'daily_percent') limit 1;", [$vechile->id]);
            if ($request->daily_revenue_cost > 0) {

                $boxVechile = new BoxVechile;
                $boxVechile->vechile_id = $vechile->id;
                $boxVechile->foreign_type = 'driver';
                $boxVechile->foreign_id = $driver->id;
                $boxVechile->bond_type = 'take';
                $boxVechile->payment_type = 'internal transfer';
                $boxVechile->money = $request->daily_revenue_cost;
                $boxVechile->tax = 0;
                $boxVechile->total_money = $request->daily_revenue_cost;
                $boxVechile->bond_state = 'deposited';
                $boxVechile->descrpition = 'عائد يومى للمركبة ' . $vechile->id . ' على السائق ' . $driver->name;
                $boxVechile->add_date = Carbon::now();
                $totalMoneyAddForDriver += $request->daily_revenue_cost;

                $boxVechile->save();
            }

            if ($request->maintenance_revenue_cost > 0) {
                $boxDriver = new BoxDriver;
                $boxDriver->driver_id = $driver->id;
                $boxDriver->foreign_type = 'stakeholders';
                $boxDriver->foreign_id = $maintenance->id;
                $boxDriver->bond_type = 'spend';
                $boxDriver->payment_type = 'internal transfer';
                $boxDriver->bond_state = 'deposited';
                $boxDriver->descrpition = 'عائد يومى لصيانة للمركبة ' . $driver->id . ' على السائق ' . $driver->name;
                $boxDriver->money = $request->maintenance_revenue_cost;
                $boxDriver->tax = 0;
                $boxDriver->total_money = $request->maintenance_revenue_cost;
                $boxDriver->add_date = Carbon::now();
                $maintenance->account += $request->maintenance_revenue_cost;
                $maintenance->save();
                $totalMoneyAddForDriver += $request->maintenance_revenue_cost;

                $boxDriver->save();
            }

            if ($request->identity_revenue_cost > 0) {
                $boxDriver = new BoxDriver;
                $boxDriver->driver_id = $driver->id;
                $boxDriver->foreign_type = 'stakeholders';
                $boxDriver->foreign_id = $identity->id;
                $boxDriver->bond_type = 'spend';
                $boxDriver->payment_type = 'internal transfer';
                $boxDriver->bond_state = 'deposited';
                $boxDriver->descrpition = 'عائد يومى للتجديد الإقامة ' . $driver->id . ' على السائق ' . $driver->name;
                $boxDriver->money = $request->identity_revenue_cost;
                $boxDriver->tax = 0;
                $boxDriver->total_money = $request->identity_revenue_cost;
                $boxDriver->add_date = Carbon::now();
                // $driver->account -=  $request->identity_revenue_cost;
                $totalMoneyAddForDriver += $request->identity_revenue_cost;

                $identity->account += $request->identity_revenue_cost;
                $identity->save();
                $boxDriver->save();
            }
            $vechile->account = $vechile->account + $request->daily_revenue_cost;
            $vechile->daily_revenue_cost = $request->daily_revenue_cost;
            $vechile->maintenance_revenue_cost = $request->maintenance_revenue_cost;
            $vechile->identity_revenue_cost = $request->identity_revenue_cost;
            $vechile->save();

            $driver->account -= $totalMoneyAddForDriver;
            $driver->save();
            $request->session()->flash('status', 'تم تسليم مركبة للسائق');
            return redirect('driver/details/' . $driver->id);
            // return dd($vechile);
        } else {
            $request->session()->flash('error', 'خطاء فى البيانات ');
            return redirect('driver/details/' . $request->id);
        }

    }
    public function availables()
    {
        $drivers = Driver::select(['id', 'name', 'phone'])->where('available', true)->get();
        return view('driver.availbleDriver', compact('drivers'));
    }

    public function driver_active($id)
    {
        $driver = Driver::find($id);
        if ($driver !== null) {
            $note = new DriverNotes;
            $note->note_type = 'قبول السائق';
            $note->content = 'تم الموافق على قبول السائق من قبل المستخدم: ' . Auth::guard('admin')->user()->name;
            $note->add_date = Carbon::now();
            $note->admin_id = Auth::guard('admin')->user()->id;
            $note->driver_id = $id;
            $note->save();
            $driver->admin_id = Auth::guard('admin')->user()->id;
            $driver->state = 'waiting';
            $driver->save();
        }
        return back();
    }

    public function show_report(Request $request)
    {
        $search = '';
        if ($request->has('from_date') && $request->has('to_date')) {
            $search = " and date(box_driver.add_date) BETWEEN '" . $request->from_date . "' AND '" . $request->to_date . "' ";
        }
        $sql = "
        select driver.id, driver.name, driver.phone ,sum(box_driver.total_money)  as total
           from driver , box_driver where driver.id = box_driver.driver_id and
           box_driver.bond_type = 'take'
           " . $search . "
           group by driver.id;
       ";
        $data = DB::select($sql);

        // return $data;

        return view('driver.reports.showReports', compact('data'));
    }
    public function show_report_status()
    {

        $data = Driver::select(['id', 'name', 'state', 'nationality', 'ssd', 'id_expiration_date', 'contract_end_date', 'final_clearance_date'])->get();
        return view('driver.reports.showReportStatus', compact('data'));
    }

    public function show_debits()
    {
        $data = Driver::select(['id', 'name', 'phone', 'account'])
            ->where('account', '<=', -5000)->orderBy('account', 'asc')->get();
        return view('driver.reports.showDebits', compact('data'));

    }

    public function driver_sample_show($id)
    {

        $driver = Driver::find($id);
        $user = Admin::find(Auth::guard('admin')->user()->id);
        if ($driver !== null && $user != null) {

            return view('driver.sample_delegate.sample', compact('driver', 'user'));

        }
        return back();

    }
    public function driver_delegate_show($id)
    {
        if ($id !== null) {
            $contract = Contract::where('id_driver', $id)->orderBy('id', 'desc')->first();
            if ($contract != null) {

                return view('driver.sample_delegate.delegete', compact('contract'));

            }
            session()->flash('error', 'خطاء لا يوجد عقد لهذا السائق ');
        }

        return back();

    }
    public function driver_receive_show(Driver $driver, Vechile $vechile=null)
    {
        if($vechile == null){
            session()->flash('error', 'خطاء السائق غير مستلم مركبة ');
            return back();
        }
        $covenant =  CovenantItem::where('current_driver', $driver->id)->where('state', 'active')->first();

        if ($covenant !== null) {
            return view('driver.sample_delegate.receiveCovenantFromDriver', compact('driver' , 'vechile' , 'covenant'));
        }else{
            session()->flash('error', 'خطاء لا يوجد عهدة مستلمه  ');
        }

        return back();

    }

    public function driver_deleivered_show(Driver $driver, Vechile $vechile=null)
    {
        if($vechile == null){
            session()->flash('error', 'خطاء السائق غير مستلم مركبة ');
            return back();
        }
        $covenant =  CovenantItem::where('current_driver', $driver->id)->where('state', 'active')->first();

        if ($covenant !== null) {
            return view('driver.sample_delegate.receiveCovenantFromDriver', compact('driver' , 'vechile' , 'covenant'));
        }
        else{
            session()->flash('error', 'خطاء لا يوجد عهدة مستلمه  ');
        }
        return back();
    }

}
