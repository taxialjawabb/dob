<?php

namespace App\Http\Controllers\Admin\Groups\SharedGroups;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Contract\Contract;
use App\Models\Driver;
use App\Models\Driver\DriverNotes;
use App\Models\Groups\Group;
use App\Models\Groups\GroupUser;
use App\Models\Vechile;
use App\Models\Vechile\VechileNotes;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class SharedGroupsController extends Controller
{

    public function show_vechile($id)
    {
        if ($this->hasPermissionData($id) == false) {
            return back();
        }

        if ($id == 'aljwab') {
            $vechiles = Vechile::select(['id', 'vechile_type', 'made_in', 'plate_number', 'color', 'state', DB::raw('account as group_balance'), 'daily_revenue_cost', 'maintenance_revenue_cost', 'identity_revenue_cost'])->whereNull('group_id')->get();
            return view('groups.shared.vechile.showGroupVechile', compact('vechiles', 'id'));
        }
        $group = null;
        if (Auth::user()->isAbleTo('manage_group')) {
            $group = Group::find($id);
        } else {
            $groupUser = GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $id)->get();

            if (count($groupUser) > 0) {
                $group = Group::find($id);

            }
        }
        if ($group !== null) {
            $vechiles = $group->vechiles;
            return view('groups.shared.vechile.showGroupVechile', compact('vechiles', 'id', 'group'));
        } else {
            session()->flash('error', ' لابمكن الدخول الي هذه المجموعة');
            return back();
        }
    }
    public function show_user($id)
    {
        if ($this->hasPermissionData($id) == false) {
            return back();
        }

        if ($id === 'aljwab' || $id == 1) {
            session()->flash('error', 'هذه المجموعة لا تحتوى على مستخدمين مسؤالين للإدارتها');
            return back();
        }

        $group = Group::find($id);
        if ($group !== null) {

            if (Auth::user()->isAbleTo('manage_group') || $group->manager_id == Auth::guard('admin')->user()->id) {
                $users = $group->users;
                return view('groups.shared.user.showGroupUser', compact('users', 'id', 'group'));
            }

        }

        session()->flash('error', ' لابمكن الدخول الي هذه المجموعة');
        return back();

    }
    public function user_show($groupid, $id)
    {
        if ($this->hasPermissionData($groupid) == false) {
            return back();
        }

        $groups = Group::where('manager_id', Auth::guard('admin')->user()->id)->where('id', $groupid)->get();

        if (count($groups) > 0 || Auth::user()->isAbleTo('manage_group')) {
            $user = Admin::find($id);
            if ($user !== null) {
                $group = Group::find($groupid);
                return view('groups.shared.user.detials', compact('user', 'group'));
            }

        }
        return back();
    }
    public function add_user($id)
    {
        if ($this->hasPermissionData($id) == false) {
            return back();
        }

        $groups = Group::where('id', $id)->where('manager_id', Auth::guard('admin')->user()->id)->get();

        if (count($groups) > 0) {
            $group = Group::find($id);
            return view('groups.shared.user.addUser', compact('id', 'group'));
        }
        session()->flash('error', '  لابمكن الدخول الي هذه المجموعة مدير المجموعه فقط من يضيف مستخدم');
        return back();
    }
    public function save_user(Request $request)
    {

        $request->validate([
            "name" => "required|string",
            "phone" => "required|numeric",
            "nationality" => "required|string",
            "ssd" => "required",
            "password" => "required",
            "working_hours" => "required|numeric",
            "monthly_salary" => "required|numeric",
            "date_join" => "required",
            "Employment_contract_expiration_date" => "required",
            "final_clearance_exity_date" => "required",
        ]);
        if ($this->hasPermissionData($request->group_id) == false) {
            return back();
        }

        $checkPhone = Admin::select('id')->where('phone', $request->phone)->orWhere('ssd', $request->ssd)->get();
        if (count($checkPhone) === 0) {
            $admin = new Admin;
            $admin->name = $request->name;
            $admin->phone = $request->phone;
            $admin->department = 'group_manager';
            $admin->nationality = $request->nationality;
            $admin->ssd = $request->ssd;
            $admin->password = \Illuminate\Support\Facades\Hash::make($request->password);
            $admin->working_hours = $request->working_hours;
            $admin->monthly_salary = $request->monthly_salary;
            $admin->date_join = $request->date_join;
            $admin->Employment_contract_expiration_date = $request->Employment_contract_expiration_date;
            $admin->final_clearance_exity_date = $request->final_clearance_exity_date;
            $admin->add_by = Auth::guard('admin')->user()->id;
            $admin->save();

            $admin->syncPermissions(['user_group']);
            GroupUser::create([
                'user_id' => $admin->id,
                'group_id' => $request->group_id,
                'state' => 'active',
            ]);
            $request->session()->flash('status', 'تم إضافة المستخدم بنجاح');
            return redirect('shared/groups/show/users/' . $request->group_id);
        } else {
            $request->session()->flash('error', 'الرجاء التأكد من البيانات المدخلة');
        }
        return back();
    }
    public function change_state($id, $user_id)
    {
        if ($this->hasPermissionData($id) == false) {
            return back();
        }

        $group = Group::find($id);
        if ($group != null) {

            if ($group->manager_id == Auth::guard('admin')->user()->id) {

                $groupUser = GroupUser::where('user_id', $user_id)->where('group_id', $id)->get();

                if (count($groupUser) > 0) {
                    $groupUser[0]->state = $groupUser[0]->state === 'active' ? 'blocked' : 'active';

                    $groupUser[0]->save();

                    return back();
                }
            } else {

                session()->flash('error', 'ليس لديك صلاحيه استبعاد الموظفين مدير المجموعه فقط من يقوم باستبعاد الموظفين');
            }

        }

        return back();

    }

    public function show_driver($id)
    {
        if ($this->hasPermissionData($id) == false) {
            return back();
        }

        if ($id === 'aljwab') {
            $group = Group::find($id);
            $drivers = Driver::select(['id', 'name', 'nationality', 'state', 'phone', DB::raw('account as group_balance')])->whereNull('group_id')->get();
            $id = 1;
            return view('groups.shared.showGroupDriver', compact('drivers', 'id', 'group'));
        }
        $group = null;

        if (Auth::user()->isAbleTo('manage_group')) {
            $group = Group::find($id);
        } else {
            $groupUser = GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $id)->get();
            if (count($groupUser) > 0) {
                $group = Group::find($id);

            }
        }

        if ($group !== null) {
            $drivers = $group->drivers;

            return view('groups.shared.driver.showGroupDriver', compact('drivers', 'id', 'group'));
        } else {
            return back();
        }
    }
    public function driver_show($id, $groupid)
    {
        if ($this->hasPermissionData($groupid) == false) {
            return back();
        }

        $group = GroupUser::where('user_id', Auth::guard('admin')->user()->id)
            ->where('group_id', $groupid)->first();

        if ($group !== null || (Auth::user()->isAbleTo('manage_group'))) {
            $driver = Driver::find($id);
           
            if ($driver != null) {
                if($driver->state=='blocked')
                {
                    session()->flash('status', 'هذا السائق مستبعد');
                    return back();
                }
                $group = Group::find($groupid);
                $vechile = Vechile::find($driver->current_vechile);
                return view('groups.shared.driver.detials', compact('driver', 'vechile', 'groupid', 'group'));
            }
        }
        return back();
    }

    public function update_driver_show($id, $groupid)
    {
        if ($this->hasPermissionData($groupid) == false) {
            return back();
        }

        $driver = Driver::find($id);
        if ($driver !== null) {
            $group = Group::find($groupid);
            return view('groups.shared.driver.updateDriver', compact('driver', 'group'));
        }

        return back();
    }
    public function update_driver_save(Request $request)
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

            if ($driver->monthly_salary != $request->monthly_salary) {
                $note .= ' تم تغيير الراتب الشهرى من  ' . ($driver->monthly_salary == null ? ' فارغ ' : $driver->monthly_salary) . ' الي ' . $request->monthly_salary;
            }
            $driver->monthly_salary = $request->monthly_salary;

            if ($driver->monthly_deduct != $request->monthly_deduct) {
                $note .= 'تم تغير قيمة الاستقطاع الشهرى من:' . ($driver->monthly_deduct == null ? ' فارغ ' : $driver->monthly_deduct) . ' الي ' . $request->monthly_deduct;
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

            $driver->admin_id = Auth::guard('admin')->user()->id;
            $driver->group_id = $request->stakeholder;

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

    public function show_contracts($id,$state)
    {

        if ($this->hasPermissionData($id) == false) {
            return back();
        }

        $user = GroupUser::where('group_id', $id)->where('user_id', Auth::guard('admin')->user()->id)->get();
        if (count($user) > 0) {
            $drivers = Driver::where('group_id', $id)->get();
            $group = Group::find($id);
            $list = [];
            for ($v = 0; $v < count($drivers); $v++) {
                $list[$v] = $drivers[$v]->id;
            }
          
            $contracts = Contract::select(['id', 'contract_number', 'car_plate_number', 'add_by'])->where('contract_status',$state=='valid'?'ساري':'لاغي')->with('added_by:id,name')
                ->whereIn('id_driver', $list)
                ->with(['contract_data' => function ($query) {
                    return $query->orderBy('id', 'desc')->get();
                }])->get();
            return view('groups.shared.contract.showContractsForGroup', compact('contracts', 'id', 'group','state'));

        }

        return back();

    }

    public function group_details(Group $group)
    {
        if ($this->hasPermissionData($group->id) == false) {
            return back();
        }
        if (($group->vechile_counter ==0||$group->vechile_counter ==null)&&Auth::user()->isAbleTo('manage_group')==false)
            return back();



        return view('groups.shared.showGroupsDetails', compact('group'));

    }
    public function add_vechile($id)
    {

        if ($this->hasPermissionData($id) == false) {
            return back();
        }

        $groupsuser = GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $id)->where('state', '=', 'active')->get();

        $groups = Group::where('manager_id', Auth::guard('admin')->user()->id)->get();

        if (count($groupsuser) > 0 || count($groups) > 0 || (Auth::user()->isAbleTo('manage_group'))) {
            $group = Group::find($id);
            $cat = \App\Models\Category::select('id', 'category_name')->get();
            return view('groups.shared.vechile.addVechile', compact('id', 'cat', 'group'));
        }
        session()->flash('error', ' لابمكن الدخول الي هذه المجموعة');
        return back();
    }

    public function save_vechile(Request $request)
    {

        $request->validate([
            'vechile_type' => ['required', 'string'],
            'made_in' => ['required', 'string'],
            'serial_number' => ['required', 'string'],
            'plate_number' => ['required', 'string'],
            'color' => ['required', 'string'],
            'driving_license_expiration_date' => ['required', 'date'],
            'insurance_card_expiration_date' => ['required', 'date'],
            'periodic_examination_expiration_date' => ['required', 'date'],
            'operating_card_expiry_date' => ['required', 'date'],
            'category_id' => ['required', 'integer'],
            'secondary_id' => ['required', 'integer'],

            'registration_type' => ['required', 'string'],
            'operation_card_number' => ['required', 'string'],
            'fuel_type' => ['required', 'string'],
            'amount_fuel' => ['required', 'string'],
            'insurance_policy_number' => ['required', 'string'],
            'insurance_type' => ['required', 'string'],

        ]);

        if ($this->hasPermissionData($request->stakeholder) == false) {
            return back();
        }

        $vec = Vechile::where('plate_number', $request->plate_number)->orWhere('serial_number', $request->serial_number)->get();

        if (count($vec) > 0) {

            $request->session()->flash('error', 'الرجاء التأكد من رقم اللوحة او رقم التسلسلى');
            return back();
        } else {
            $vechile = new Vechile;
            $vechile->vechile_type = $request->vechile_type;
            $vechile->made_in = $request->made_in;
            $vechile->serial_number = $request->serial_number;
            $vechile->plate_number = $request->plate_number;
            $vechile->color = $request->color;
            $vechile->driving_license_expiration_date = $request->driving_license_expiration_date;
            $vechile->insurance_card_expiration_date = $request->insurance_card_expiration_date;
            $vechile->periodic_examination_expiration_date = $request->periodic_examination_expiration_date;
            $vechile->operating_card_expiry_date = $request->operating_card_expiry_date;
            $vechile->category_id = $request->category_id;
            $vechile->secondary_id = $request->secondary_id;
            $vechile->daily_revenue_cost = 0;
            $vechile->maintenance_revenue_cost = 0;
            $vechile->identity_revenue_cost = 0;
            $vechile->registration_type = $request->registration_type;
            $vechile->operation_card_number = $request->operation_card_number;
            $vechile->fuel_type = $request->fuel_type;
            $vechile->amount_fuel = $request->amount_fuel;
            $vechile->insurance_policy_number = $request->insurance_policy_number;
            $vechile->insurance_type = $request->insurance_type;
            $vechile->add_date = Carbon::now();
            $vechile->admin_id = Auth::guard('admin')->user()->id;

            if ($request->stakeholder !== 0) {
                if ($request->stakeholder !== 1) {
                    $group = Group::find($request->stakeholder);
                    if ($group->vechile_counter > $group->added_vechile) {
                        $group->added_vechile++;
                        $group->save();
                    } else {
                        $request->session()->flash('error', 'لا يمكنك أضافة مركبات فى هذه المجموع مكتملة');
                        return back();
                    }
                }
                $vechile->group_id = $request->stakeholder;
            }
            $vechile->save();
            $request->session()->flash('status', 'تم إضافة المركبة بنجاح');
            return redirect()->route("shared.groups.vechiles.show", ["id" => $request->stakeholder]);
        }

    }

    public function add_driver($id)
    {

        if ($this->hasPermissionData($id) == false) {
            return back();
        }

        $groupusers = GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $id)->where('state', '=', 'active')->get();

        $groups = Group::where('manager_id', Auth::guard('admin')->user()->id)->get();

        if (count($groupusers) > 0 || count($groups) > 0 || (Auth::user()->isAbleTo('manage_group'))) {
            $group = Group::find($id);
            return view('groups.shared.driver.addDriver', compact('id', 'group'));
        }
        session()->flash('error', ' لابمكن الدخول الي هذه المجموعة');
        return back();
    }
    public function save_driver(Request $request)
    {

        $request->validate([
            "group_id" => 'required|string',
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
        ]);
        if ($this->hasPermissionData($request->group_id) == false) {
            return back();
        }

        $driverData = Driver::where('ssd', $request->ssd)->orWhere('phone', $request->phone)->get();
        if (count($driverData) > 0) {
            $request->session()->flash('error', 'الرجاء التأكد من البيانات المدخلة');
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
            $driver->admin_id = Auth::guard('admin')->user()->id;
            if ($request->stakeholder !== 0) {
                if ($request->stakeholder !== 1) {
                    $group = Group::find($request->group_id);
                    if ($group->vechile_counter > $group->added_driver) {
                        $group->added_driver++;
                        $group->save();
                    } else {
                        $request->session()->flash('error', 'لا يمكنك أضافة سائقين فى هذه المجموع مكتملة');
                        return back();
                    }
                }
                $driver->group_id = $request->group_id;
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
            return redirect('shared/groups/show/drivers/' . $request->group_id);
        }

    }
    public function vechile_show($id, $groupid)
    {

        if ($this->hasPermissionData($groupid) == false) {
            return back();
        }

        $groupuser = GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $groupid)->get();

        if (count($groupuser) > 0 || (Auth::user()->isAbleTo('manage_group'))) {
            $group = Group::find($groupid);
            $vechile = Vechile::with('added_by')->with('category')->with('secondary_category')->find($id);
            // return $vechile;
            return view('groups.shared.vechile.detials', compact('vechile', 'group'));

        }
        return back();
    }

    public function change_driver_state($group, $id)
    {
        if ($this->hasPermissionData($group) == false) {
            return back();
        }

        $groupuser = GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $group)->get();

        if (count($groupuser) > 0) {
            $driver = Driver::find($id);
            $grups = Group::find($group);
            if ($driver != null) {

                if ($driver->state == 'blocked' || $driver->state == 'waiting') {
                    if ($driver->state == 'blocked') {
                        if($driver->back!=0)
                        {
                            session()->flash('status', 'لايمكن استرجاع هذا السائق لقد تم استكمال عدد محاولات الاسترجاع');
                            return back();
                        
                        }
                        if ($grups->vechile_counter > $grups->added_driver) {
                            $grups->added_driver++;

                            $note = new DriverNotes;
                            $note->note_type = "تغيير حالة السائق";
                            $note->content = "لقم تم تغيير حاله السائق من محظور الي انتظار";
                            $note->add_date = Carbon::now();
                            $note->admin_id = Auth::guard('admin')->user()->id;
                            $note->driver_id = $id;
                            $note->save();

                            $grups->save();
                            $driver->state = "waiting";
                            $driver->back=1;
                            $driver->save();
                            session()->flash('status', 'تم تحويل حاله السائق الي انتظار');
                            return back();
                        } else {
                            session()->flash('status', 'لايمكن استرجاع هذا السائق لقد تم استكمال عدد سائقين لهذه مجموعه');
                        }
                    } elseif ($driver->state == 'waiting') {

                        $grups->added_driver == 0 ? 0 : $grups->added_driver--;
                        $grups->save();
                        $driver->state = "blocked";
                        $driver->save();
                        $note = new DriverNotes;
                        $note->note_type = "تغيير حالة السائق";
                        $note->content = "لقم تم تغيير حاله السائق من انتظار الي محظور";
                        $note->add_date = Carbon::now();
                        $note->admin_id = Auth::guard('admin')->user()->id;
                        $note->driver_id = $id;
                        $note->save();
                        session()->flash('status', 'تم تحويل حاله السائق الي محظور');
                        return back();
                    } else {
                        session()->flash('status', 'يجب تسليم السياره اولا قبل تحويل حاله السائق');
                    }
                } else {
                    session()->flash('status', 'يتم الاستبعاد او الغاء ف حالة سائق انتظار او محظور');
                }
            } else {
                session()->flash('status', 'خطأ ف بيانات المجموعه او سائق');
            }
        } else {
            session()->flash('status', 'تأكد من صلاحيات');
        }
        return back();
    }
    public function change_vechile_state($group, $id)
    {
        if ($this->hasPermissionData($group) == false) {
            return back();
        }

        $groupuser = GroupUser::where('user_id', Auth::guard('admin')->user()->id)->where('group_id', $group)->get();

        if (count($groupuser) > 0) {
            $vechile = Vechile::find($id);
            $grups = Group::find($group);
            if ($vechile != null) {
                if ($vechile->state == 'blocked' || $vechile->state == 'waiting') {
                    if ($vechile->state == 'blocked') {
                        if ($grups->vechile_counter > $grups->added_vechile) {
                            $grups->added_vechile++;
                            $grups->save();
                            $vechile->state = "waiting";
                            $vechile->save();
                            $note = new VechileNotes;
                            $note->note_type = "تغيير حالة المركبه";
                            $note->content = "لقم تم تغيير حاله المركبه من محظور الي انتظار";
                            $note->add_date = Carbon::now();
                            $note->admin_id = Auth::guard('admin')->user()->id;
                            $note->vechile_id = $id;
                            $note->save();
                            session()->flash('status', 'تم تحويل حاله المركبة الي انتظار');
                            return back();
                        } else {
                            session()->flash('status', 'لايمكن استرجاع هذا المركبة لقد تم استكمال عدد المركبات لهذه مجموعه');
                        }
                    } elseif ($vechile->state == 'waiting') {

                        $grups->added_vechile == 0 ? 0 : $grups->added_vechile--;
                        $grups->save();
                        $vechile->state = "blocked";
                        $vechile->save();
                        $note = new VechileNotes;
                        $note->note_type = "تغيير حالة المركبه";
                        $note->content = "لقم تم تغيير حاله المركبه من انتظار الي محظور";
                        $note->add_date = Carbon::now();
                        $note->admin_id = Auth::guard('admin')->user()->id;
                        $note->vechile_id = $id;
                        $note->save();
                        session()->flash('status', 'تم تحويل حاله المركبة الي محظور');
                        return back();
                    } else {
                        session()->flash('status', 'يجب تسليم السياره اولا قبل تحويل حاله المركبه');
                    }
                } else {
                    session()->flash('status', 'يتم الاستبعاد او الغاء ف حالة المركبه انتظار او محظور');
                }
            } else {
                session()->flash('status', 'خطأ ف بيانات المجموعه او المركبه');
            }
        } else {
            session()->flash('status', 'تأكد من صلاحيات');
        }
        return back();
    }

    public function license_show(Group $group)
    {

        $groupuser = GroupUser::where('user_id' , Auth::guard('admin')->user()->id)->where('group_id', $group->id)->where('state', 'active')->get();



if (Auth::user()->isAbleTo('manage_group')) {
    $data = DB::select("select groups_licenses.id,  groups_licenses.type , groups_licenses.state, expire_date, attached , groups.name
            from groups_licenses left join documents_group on groups_licenses.document_id = documents_group.id
            left join groups on documents_group.group_id = groups.id where  groups.id = ?;", [$group->id]);
    return view('groups.myGroups.showLicensesRequestGroups', compact('data', 'group'));
        } else {

            if ($group->state != "active" || count($groupuser) == 0) {
                session()->flash('error',$group->state != "active"? 'المجموعة محظورة':'ليست لديك صلاحية الدخول ');
                return back();
            }
            $data = DB::select("select groups_licenses.id,  groups_licenses.type , groups_licenses.state, expire_date, attached , groups.name
            from groups_licenses left join documents_group on groups_licenses.document_id = documents_group.id
            left join groups on documents_group.group_id = groups.id where  groups.id = ?;", [$group->id]);
    return view('groups.myGroups.showLicensesRequestGroups', compact('data', 'group'));

        }
    }

    public function general_box(Group $group)
    {
        if ($this->hasPermissionData($group->id) == false) {
            return back();
        }


        $data = \DB::select("select
            t.id,t.name , added_date, sum(t.take_bonds) as take_bonds , sum(take_money) as take_money, sum(t.spend_bonds) as spend_bonds , sum(t.spend_money) as spend_money
            from
            (
            select ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, date(t1.add_date) as added_date,
            count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds,
            sum(CASE WHEN bond_type = 'take' THEN total_money ELSE 0 END) as take_money ,
            count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds,
            sum(CASE WHEN bond_type = 'spend' THEN total_money ELSE 0 END) as spend_money
            from group_internal_box t1
            left join admins ad on  t1.add_by  = ad.id and t1.id where t1.group_id =?  group by added_date , ad.id
            ) t group by added_date", [$group->id]);
        $box = \DB::select("
            select
                t.id,t.name , added_date, sum(t.take_bonds) as take_bonds , sum(take_money) as take_money, sum(t.spend_bonds) as spend_bonds , sum(t.spend_money) as spend_money
                from
                (
                select ad.id, CASE WHEN  ad.name is null THEN 'النظام' ELSE ad.name END as name, date(t1.add_date) as added_date,
                count(if(bond_type = 'take' , t1.id, NULL ))   as take_bonds,
                sum(CASE WHEN bond_type = 'take' THEN total_money ELSE 0 END) as take_money ,
                count(if(bond_type = 'spend' , t1.id, NULL ))  as spend_bonds,
                sum(CASE WHEN bond_type = 'spend' THEN total_money ELSE 0 END) as spend_money
                from group_internal_box t1
                left join admins ad on  t1.add_by  = ad.id and t1.id where t1.group_id =?
                ) t
            ", [$group->id]);
        return view('groups.shared.generalBox.generalBox', compact('data', 'box', 'group'));
    }

}
