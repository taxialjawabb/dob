<?php

namespace App\Http\Controllers\Admin\Driver\Contract;

use App\Http\Controllers\Controller;
use App\Models\Contract\Contract;
use App\Models\Contract\ContractData;
use App\Models\Driver;
use App\Models\DriverVechile;
use App\Models\Driver\DriverNotes;
use App\Models\Groups\GroupUser;
use App\Models\Vechile\BoxVechile;
use App\Traits\GeneralTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContractController extends Controller
{

    use GeneralTrait;
    public function show_adding($id=null)
    {


        if($id!=null)
        {

            $user=GroupUser::where('group_id',$id)->where('user_id',Auth::guard('admin')->user()->id)->get();
            if (count($user))
            {

                $driver = Driver::where('state', 'waiting')->where('group_id', $id)->get();
                $vechile = \App\Models\Vechile::where('state', 'waiting')->where('group_id', $id)->get();
                return view('contract.addContract', compact('driver', 'vechile','' ));
            }
        }
        else if(Auth::guard('admin')->user()->hasPermission('contract_manage'))
        {

            $driver = Driver::where('state', 'waiting')->whereIn('group_id',[null,'1'])->get();
            $vechile = \App\Models\Vechile::where('state', 'waiting')->whereIn('group_id',[null,'1'])->get();
            return view('contract.addContract', compact('driver', 'vechile', ));
        }
        return back();




    }

    public function end_contract_show($id)
    {
        $contract = Contract::find($id);
        if ($contract != null) {
            $contract_id = $contract->id;
            return view('contract.endContract', compact('contract_id'));
        }
        return back();

    }
    public function end_contract_view(Request $req)
    {

        $contract = Contract::find($req->contract_id);

        $contract_data = ContractData::where('contract_id', $req->contract_id)->latest('id')->first();
        $request = $req;
        return view('contract.endContractDetails', compact('contract', 'contract_data', 'request'));
    }
    public function end_contract(Request $request)
    {

        $request->validate([
            'id' => 'required|string',
            'car_return_odometer_reading_at_entery' => 'required|string',
            'car_technical_condition_at_return_air_condition' => 'required|string',
            'car_technical_condition_at_return_radio_recorder' => 'required|string',
            'car_technical_condition_at_return_interior_screen' => 'required|string',
            'car_technical_condition_at_return_speedometer' => 'required|string',
            'car_technical_condition_at_return_interior_upholstery' => 'required|string',
            'car_technical_condition_at_return_spare_cover_equipment' => 'required|string',
            'car_technical_condition_at_return_wheel' => 'required|string',
            'car_technical_condition_at_return_spare_wheel' => 'required|string',
            'car_technical_condition_at_return_first_aid_kit' => 'required|string',
            'car_technical_condition_at_return_oil_change_time' => 'required|string',
            'car_technical_condition_at_return_key' => 'required|string',
            'car_technical_condition_at_return_fire_extinguisher_availability' => 'required|string',
            'car_technical_condition_at_return_availability_triangle_refactor' => 'required|string',
            'car_technical_condition_at_return_printer' => 'required|string',
            'car_technical_condition_at_return_point_sale_device' => 'required|string',
            'car_technical_condition_at_return_fornt_screen' => 'required|string',
            'car_technical_condition_at_return_internal_camera' => 'required|string',
            'car_technical_condition_at_return_4sensor_seat' => 'required|string',
            'car_technical_condition_at_return_button_emergency' => 'required|string',
            'car_technical_condition_at_return_device_tracking' => 'required|string',
            'car_technical_condition_at_return_light_taxi_mark' => 'required|string',
            'car_technical_condition_at_return_dvr' => 'required|string',
        ]);
        $contract = Contract::find($request->id);
        if ($contract === null) {
            return $this->returnError('E001', 'خطاء فى البيانات المرسلة الرجاء المحاولة لاحقا');
        }
        $contract->car_return_odometer_reading_at_entery = $request->car_return_odometer_reading_at_entery;
        $contract->car_technical_condition_at_return_air_condition = $request->car_technical_condition_at_return_air_condition;
        $contract->car_technical_condition_at_return_radio_recorder = $request->car_technical_condition_at_return_radio_recorder;
        $contract->car_technical_condition_at_return_interior_screen = $request->car_technical_condition_at_return_interior_screen;
        $contract->car_technical_condition_at_return_speedometer = $request->car_technical_condition_at_return_speedometer;
        $contract->car_technical_condition_at_return_interior_upholstery = $request->car_technical_condition_at_return_interior_upholstery;
        $contract->car_technical_condition_at_return_spare_cover_equipment = $request->car_technical_condition_at_return_spare_cover_equipment;
        $contract->car_technical_condition_at_return_wheel = $request->car_technical_condition_at_return_wheel;
        $contract->car_technical_condition_at_return_spare_wheel = $request->car_technical_condition_at_return_spare_wheel;
        $contract->car_technical_condition_at_return_first_aid_kit = $request->car_technical_condition_at_return_first_aid_kit;
        $contract->car_technical_condition_at_return_oil_change_time = $request->car_technical_condition_at_return_oil_change_time;
        $contract->car_technical_condition_at_return_key = $request->car_technical_condition_at_return_key;
        $contract->car_technical_condition_at_return_fire_extinguisher_availability = $request->car_technical_condition_at_return_fire_extinguisher_availability;
        $contract->car_technical_condition_at_return_availability_triangle_refactor = $request->car_technical_condition_at_return_availability_triangle_refactor;
        $contract->car_technical_condition_at_return_printer = $request->car_technical_condition_at_return_printer;
        $contract->car_technical_condition_at_return_point_sale_device = $request->car_technical_condition_at_return_point_sale_device;
        $contract->car_technical_condition_at_return_fornt_screen = $request->car_technical_condition_at_return_fornt_screen;
        $contract->car_technical_condition_at_return_internal_camera = $request->car_technical_condition_at_return_internal_camera;
        $contract->car_technical_condition_at_return_4sensor_seat = $request->car_technical_condition_at_return_4sensor_seat;
        $contract->car_technical_condition_at_return_button_emergency = $request->car_technical_condition_at_return_button_emergency;
        $contract->car_technical_condition_at_return_device_tracking = $request->car_technical_condition_at_return_device_tracking;
        $contract->car_technical_condition_at_return_light_taxi_mark = $request->car_technical_condition_at_return_light_taxi_mark;
        $contract->car_technical_condition_at_return_dvr = $request->car_technical_condition_at_return_dvr;
        $contract->car_technical_condition_at_return_notes = $request->car_technical_condition_at_return_notes;
        $contract->ending_by = Auth::guard('admin')->user()->id;

        $contract->date_ending = \Carbon\Carbon::now();
        $contract->contract_status = "لاغي";
        $contract->save();
        $contract_data = ContractData::where('contract_id', $request->id)->latest('id')->first();
        $contract_data->contract_status = 'لاغي';
        $contract_data->ending_by = Auth::guard('admin')->user()->id;
        $contract_data->date_ending = \Carbon\Carbon::now();
        $contract_data->save();

        $driver = \App\Models\Driver::find($contract->id_driver);
        $vechile = \App\Models\Vechile::find($contract->vechile_id);

        $vechile->state = 'waiting';
        $driver->state = 'waiting';
        $driver->current_vechile = null;
        $vechile->save();
        $driver->save();
        $driverVechile = DriverVechile::where('vechile_id', $contract->vechile_id)->where('driver_id', $contract->id_driver)->where('end_date_drive', null)->where('reason', null)->orderBy('start_date_drive', 'desc')->limit(1)->get();
        if (count($driverVechile) > 0) {
            $driverVechile[0]->end_date_drive = Carbon::now();
            $driverVechile[0]->payedRegister = Carbon::now()->diffInDays($driverVechile[0]->start_date_drive);
            $driverVechile[0]->reason = 'تم تغيير الحاله من active  الي watting';
            $driverVechile[0]->save();
        }

        $note = new DriverNotes;
        $note->note_type = 'إنهاء التعاقد';
        $note->content = "تم إنهاء عقد للسائق للمركبة رقم : " . $vechile->plate_number . " فى يوم " . Carbon::now();
        $note->add_date = Carbon::now();
        $note->admin_id = Auth::guard('admin')->user()->id;
        $note->driver_id = $driver->id;
        $note->save();

        $request->session()->flash('status', 'تمت انهاء العقد بنجاح');

        return redirect('driver/contract/show/contracts');



    }

    public function extension_contract(Request $request)
    {

        $request->validate([
            'contract_id' => 'required|string',
            'lease_term' => 'required|string',
            'lease_cost_dar_hour' => 'required|string',
            'main_financial_vat' => 'required|string',
        ]);

        $contract = \App\Models\Contract\Contract::with(['contract_data' => function ($query) {
            return $query->orderBy('id', 'desc')->first();
        }])->find($request->contract_id);

        // return $contract;
        if ($contract === null) {
            return $this->returnError('E001', 'خطاء فى البيانات المرسلة الرجاء المحاولة لاحقا');
        }
        $contract_data = new ContractData();
        $dateStart = clone $contract->contract_data[0]->contract_end_datetime;

        if ($dateStart >= \Carbon\Carbon::now()) {
            $dateStart = $dateStart->addDay();

        } else {
            $dateStart = \Carbon\Carbon::now();

        }
        $endDate = clone $dateStart;
        $endDate = $endDate->addDays($request->lease_term - 1);
        // return $contract->contract_data[0]->contract_end_datetime .'============'.$dateStart .'============'. $endDate;
        $value = $request->lease_cost_dar_hour * $request->lease_term;
        $value2 = $value * $request->main_financial_vat;
        $total = ($value + ($value2 / 100));
        $contract_status_before = $contract->contract_end_datetime >= \Carbon\Carbon::now() ? 'ساري' : 'منتهي';
        $contract_data->contract_id = $contract->id;
        $contract_data->contract_start_datetime = $dateStart;
        $contract_data->contract_end_datetime = $endDate;
        $contract_data->contract_status_before = $contract_status_before;
        $contract_data->contract_status = 'ساري';
        $contract_data->main_financial_vat = $request->main_financial_vat;
        $contract_data->main_financial_total_lease_cost_day_hour = $value;
        $contract_data->main_financial_total = $total;
        $contract_data->lease_term = $request->lease_term;
        $contract_data->lease_cost_dar_hour = $request->lease_cost_dar_hour;
        $contract_data->add_by = Auth::guard('admin')->user()->id;
        $contract_data->save();

        $contract->lease_cost_dar_hour = $request->lease_cost_dar_hour;
        $contract->main_financial_vat = $request->main_financial_vat;
        $contract->contract_end_datetime = $endDate;
        $contract->save();

        if ($total > 0) {
            $driver = \App\Models\Driver::find($contract->id_driver);
            $vechile = \App\Models\Vechile::find($contract->vechile_id);

            $boxVechile = new BoxVechile;
            $boxVechile->vechile_id = $contract->vechile_id;
            $boxVechile->foreign_type = 'driver';
            $boxVechile->foreign_id = $contract->id_driver;
            $boxVechile->bond_type = 'take';
            $boxVechile->payment_type = 'internal transfer';
            $boxVechile->bond_state = 'deposited';
            $boxVechile->descrpition = 'قيمة التعاقد لتأجير المركبة لمدة ' . $request->lease_term . ' للمركبة ' . $vechile->plate_number . ' على السائق ' . $driver->name;
            $boxVechile->money = $value;
            $boxVechile->tax = $request->main_financial_vat;
            $boxVechile->total_money = $total;
            $boxVechile->add_by = Auth::guard('admin')->user()->id;
            $boxVechile->add_date = Carbon::now();
            $driver->account -= $total;
            $vechile->account += $total;
            $boxVechile->save();
            $driver->save();
            $vechile->save();
        }

        return back();

    }
    public function save_data(Request $request)
    {

        $request->validate([
            'id_driver' => 'required|string',
            'contract_number' => 'required|string',
            'contract_location' => 'required|string',
            'contract_start_datetime' => 'required|string',
            'contract_end_datetime' => 'required|string',
            'contract_type' => 'required|string',
            'contract_status' => 'required|string',
            'company_name' => 'required|string',
            'company_commerical_register' => 'required|string',
            'company_vat_register' => 'required|string',
            'company_id_number' => 'required|string',
            'company_license_number' => 'required|string',
            'company_license_category' => 'required|string',
            'company_phone' => 'required|string',
            'company_address' => 'required|string',
            'company_fax' => 'required|string',
            'company_email' => 'required|string',
            'tenant_name_ar' => 'required|string',
            'tenant_brith_date' => 'required|string',
            'tenant_nationality' => 'required|string',
            'tenant_id_type' => 'required|string',
            'tenant_id_number' => 'required|string',
            'tenant_id_date_expire' => 'required|string',
            'tenant_id_version_number' => 'required|string',
            'tenant_place_issue' => 'required|string',
            'tenant_address' => 'required|string',
            'tenant_mobile' => 'required|string',
            'tenant_license_type' => 'required|string',
            'tenant_license_date_expire' => 'required|string',
            'tenant_license_number' => 'required|string',
            'car_plate_number' => 'required|string',
            'car_type' => 'required|string',
            'car_manufacture_year' => 'required|string',
            'car_color' => 'required|string',
            'car_registerion_type' => 'required|string',
            'car_operating_card_number' => 'required|string',
            'car_operating_card_number_date_expire' => 'required|string',
            'car_fuel_type' => 'required|string',
            'car_amount_fuel_present' => 'required|string',
            'car_appointment_maintenanc_date' => 'required|string',
            'car_insurance_policy_number' => 'required|string',
            'car_insurance_policy_number_date_expire' => 'required|string',
            'car_insurance_type' => 'required|string',
            'lease_term' => 'required|string',
            'lease_cost_dar_hour' => 'required|string',
            'lease_hours_delay_allowed' => 'required|string',
            'car_receipt_odometer_reading_at_exit' => 'required|string',
            'leasing_policy_return_car_before_contract_expire' => 'required|string',
            'leasing_policy_contract_extension' => 'required|string',
            'main_financial_vat' => 'required|string',
            'main_financial_total_lease_cost_day_hour' => 'required|string',
            'main_financial_total' => 'required|string',
            'car_technical_condition_at_lease_air_condition' => 'required|string',
            'car_technical_condition_at_lease_radio_recorder' => 'required|string',
            'car_technical_condition_at_lease_interior_screen' => 'required|string',
            'car_technical_condition_at_lease_speedometer' => 'required|string',
            'car_technical_condition_at_lease_interior_upholstery' => 'required|string',
            'car_technical_condition_at_lease_spare_cover_equipment' => 'required|string',
            'car_technical_condition_at_lease_wheel' => 'required|string',
            'car_technical_condition_at_lease_spare_wheel' => 'required|string',
            'car_technical_condition_at_lease_first_aid_kit' => 'required|string',
            'car_technical_condition_at_lease_oil_change_time' => 'required|string',
            'car_technical_condition_at_lease_key' => 'required|string',
            'car_technical_condition_at_lease_fire_extinguisher_availability' => 'required|string',
            'car_technical_condition_at_lease_availability_triangle_refactor' => 'required|string',
            'car_technical_condition_at_lease_printer' => 'required|string',
            'car_technical_condition_at_lease_point_sale_device' => 'required|string',
            'car_technical_condition_at_lease_fornt_screen' => 'required|string',
            'car_technical_condition_at_lease_internal_camera' => 'required|string',
            'car_technical_condition_at_lease_4sensor_seat' => 'required|string',
            'car_technical_condition_at_lease_button_emergency' => 'required|string',
            'car_technical_condition_at_lease_device_tracking' => 'required|string',
            'car_technical_condition_at_lease_light_taxi_mark' => 'required|string',
            'car_technical_condition_at_lease_dvr' => 'required|string',
        ]);
        $driver = \App\Models\Driver::find($request->id_driver);
        return $driver;
        $vechile = \App\Models\Vechile::find($request->vechile_id);
        if ($driver === null || $vechile === null) {
            return $this->returnError('E001', 'خطاء فى البيانات المرسلة الرجاء المحاولة لاحقا');
        }
        if ($request->main_financial_total > 0) {
            $boxVechile = new BoxVechile;
            $boxVechile->vechile_id = $request->vechile_id;
            $boxVechile->foreign_type = 'driver';
            $boxVechile->foreign_id = $request->id_driver;
            $boxVechile->bond_type = 'take';
            $boxVechile->payment_type = 'internal transfer';
            $boxVechile->bond_state = 'deposited';
            $boxVechile->descrpition = 'قيمة التعاقد لتأجير المركبة لمدة ' . $request->lease_term . ' للمركبة ' . $request->vechile_id . ' على السائق ' . $driver->name;
            $boxVechile->money = $request->main_financial_total_lease_cost_day_hour;
            $boxVechile->tax = $request->main_financial_vat;
            $boxVechile->total_money = $request->main_financial_total;
            $boxVechile->add_date = Carbon::now();
            $boxVechile->add_by = Auth::guard('admin')->user()->id;
            $driver->account -= $request->main_financial_total;
            $vechile->account += $request->main_financial_total;
            $boxVechile->save();
        }
        $vechile->state = 'active';
        $driver->state = 'active';
        $driver->current_vechile = $request->vechile_id;
        $vechile->save();
        $driver->save();
        $driver_vechile = new DriverVechile();
        $driver_vechile->vechile_id = $request->vechile_id;
        $driver_vechile->driver_id = $request->id_driver;
        $driver_vechile->start_date_drive = Carbon::now();
        $driver_vechile->admin_id = Auth::guard('admin')->user()->id;
        $driver_vechile->save();

        $contract = new Contract;
        $contract->id_driver = $request->id_driver;
        $contract->vechile_id = $request->vechile_id;
        $contract->contract_number = $request->contract_number;
        $contract->contract_location = $request->contract_location;

        $contract->contract_start_datetime = $request->contract_start_datetime;
        $contract->contract_end_datetime = $request->contract_end_datetime;
        $contract->contract_type = $request->contract_type;
        $contract->contract_status = $request->contract_status;

        $contract->company_name = $request->company_name;
        $contract->company_commerical_register = $request->company_commerical_register;
        $contract->company_vat_register = $request->company_vat_register;
        $contract->company_id_number = $request->company_id_number;
        $contract->company_license_number = $request->company_license_number;
        $contract->company_license_category = $request->company_license_category;
        $contract->company_phone = $request->company_phone;
        $contract->company_address = $request->company_address;
        $contract->company_fax = $request->company_fax;
        $contract->company_email = $request->company_email;

        $contract->tenant_name_ar = $request->tenant_name_ar;
        $contract->tenant_brith_date = $request->tenant_brith_date;
        $contract->tenant_nationality = $request->tenant_nationality;
        $contract->tenant_id_type = $request->tenant_id_type;
        $contract->tenant_id_number = $request->tenant_id_number;
        $contract->tenant_id_date_expire = $request->tenant_id_date_expire;
        $contract->tenant_id_version_number = $request->tenant_id_version_number;
        $contract->tenant_place_issue = $request->tenant_place_issue;
        $contract->tenant_address = $request->tenant_address;
        $contract->tenant_mobile = $request->tenant_mobile;
        $contract->tenant_license_type = $request->tenant_license_type;
        $contract->tenant_license_date_expire = $request->tenant_license_date_expire;
        $contract->tenant_license_number = $request->tenant_license_number;

        $contract->car_plate_number = $request->car_plate_number;
        $contract->car_type = $request->car_type;
        $contract->car_manufacture_year = $request->car_manufacture_year;
        $contract->car_color = $request->car_color;
        $contract->car_registerion_type = $request->car_registerion_type;
        $contract->car_operating_card_number = $request->car_operating_card_number;
        $contract->car_operating_card_number_date_expire = $request->car_operating_card_number_date_expire;
        $contract->car_fuel_type = $request->car_fuel_type;
        $contract->car_amount_fuel_present = $request->car_amount_fuel_present;
        $contract->car_appointment_maintenanc_date = $request->car_appointment_maintenanc_date;
        $contract->car_insurance_policy_number = $request->car_insurance_policy_number;
        $contract->car_insurance_policy_number_date_expire = $request->car_insurance_policy_number_date_expire;
        $contract->car_insurance_type = $request->car_insurance_type;
        $contract->lease_term = $request->lease_term;
        $contract->lease_cost_dar_hour = $request->lease_cost_dar_hour;
        $contract->lease_hours_delay_allowed = $request->lease_hours_delay_allowed;
        $contract->car_receipt_odometer_reading_at_exit = $request->car_receipt_odometer_reading_at_exit;
        $contract->leasing_policy_return_car_before_contract_expire = $request->leasing_policy_return_car_before_contract_expire;
        $contract->leasing_policy_contract_extension = $request->leasing_policy_contract_extension;

        $contract->car_technical_condition_at_lease_air_condition = $request->car_technical_condition_at_lease_air_condition;
        $contract->car_technical_condition_at_lease_radio_recorder = $request->car_technical_condition_at_lease_radio_recorder;
        $contract->car_technical_condition_at_lease_interior_screen = $request->car_technical_condition_at_lease_interior_screen;
        $contract->car_technical_condition_at_lease_speedometer = $request->car_technical_condition_at_lease_speedometer;
        $contract->car_technical_condition_at_lease_interior_upholstery = $request->car_technical_condition_at_lease_interior_upholstery;
        $contract->car_technical_condition_at_lease_spare_cover_equipment = $request->car_technical_condition_at_lease_spare_cover_equipment;
        $contract->car_technical_condition_at_lease_wheel = $request->car_technical_condition_at_lease_wheel;
        $contract->car_technical_condition_at_lease_spare_wheel = $request->car_technical_condition_at_lease_spare_wheel;
        $contract->car_technical_condition_at_lease_first_aid_kit = $request->car_technical_condition_at_lease_first_aid_kit;
        $contract->car_technical_condition_at_lease_oil_change_time = $request->car_technical_condition_at_lease_oil_change_time;
        $contract->car_technical_condition_at_lease_key = $request->car_technical_condition_at_lease_key;
        $contract->car_technical_condition_at_lease_fire_extinguisher_availability = $request->car_technical_condition_at_lease_fire_extinguisher_availability;
        $contract->car_technical_condition_at_lease_availability_triangle_refactor = $request->car_technical_condition_at_lease_availability_triangle_refactor;
        $contract->car_technical_condition_at_lease_printer = $request->car_technical_condition_at_lease_printer;
        $contract->car_technical_condition_at_lease_point_sale_device = $request->car_technical_condition_at_lease_point_sale_device;
        $contract->car_technical_condition_at_lease_fornt_screen = $request->car_technical_condition_at_lease_fornt_screen;
        $contract->car_technical_condition_at_lease_internal_camera = $request->car_technical_condition_at_lease_internal_camera;
        $contract->car_technical_condition_at_lease_4sensor_seat = $request->car_technical_condition_at_lease_4sensor_seat;
        $contract->car_technical_condition_at_lease_button_emergency = $request->car_technical_condition_at_lease_button_emergency;
        $contract->car_technical_condition_at_lease_device_tracking = $request->car_technical_condition_at_lease_device_tracking;
        $contract->car_technical_condition_at_lease_light_taxi_mark = $request->car_technical_condition_at_lease_light_taxi_mark;
        $contract->car_technical_condition_at_lease_dvr = $request->car_technical_condition_at_lease_dvr;
        $contract->main_financial_vat = $request->main_financial_vat;
        $contract->main_financial_payment_method = $request->main_financial_payment_method;
        $contract->main_financial_total_lease_cost_day_hour = $request->main_financial_total_lease_cost_day_hour;
        $contract->main_financial_total = $request->main_financial_total;
        $contract->add_by = Auth::guard('admin')->user()->id;
        $contract->add_date = Carbon::now();
        $contract->save();
        $contract_data = new ContractData;
        $contract_data->contract_id = $contract->id;
        $contract_data->contract_end_datetime = $request->contract_end_datetime;
        $contract_data->contract_start_datetime = $request->contract_start_datetime;
        $contract_data->contract_status = $request->contract_status;
        $contract_data->add_by = Auth::guard('admin')->user()->id;
        $contract_data->main_financial_vat = $request->main_financial_vat;
        $contract_data->main_financial_total = $request->main_financial_total;
        $contract_data->main_financial_total_lease_cost_day_hour = $request->main_financial_total_lease_cost_day_hour;
        $contract_data->contract_status_before = "لايوجد";
        $contract_data->lease_term = $request->lease_term;
        $contract_data->lease_cost_dar_hour = $request->lease_cost_dar_hour;
        $contract_data->save();
        $note = new DriverNotes;
        $note->note_type = 'انشاء عقد جديد';
        $note->content = "تم انشاء عقد جديد للسائق للمركبة رقم : " . $vechile->plate_number . "عدد ايام العقد: " . $request->lease_term . "تبداء من: " . $request->contract_start_datetime;
        $note->add_date = Carbon::now();
        $note->admin_id = Auth::guard('admin')->user()->id;
        $note->driver_id = $request->id_driver;
        $note->save();
        $request->session()->flash('status', 'تمت اضافت العقد بنجاح');

        return $this->returnSuccessMessage('تم إضافة العقد بنجاح',Auth::guard('admin')->user()->hasPermission('contract_manage'));

    }

    public function show_contract_details($id)
    {
        $contract = \App\Models\Contract\Contract::where('id', $id)->with(['contract_data' => function ($query) {
            return $query->get();
        }])->first();

        return view('contract.showContractDetails', compact('contract'));
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

    public function show_contracts($id=null)
    {
        if($id!=null)
        {
            $user=GroupUser::where('group_id',$id)->where('user_id',Auth::guard('admin')->user()->id)->get();
            if(count($user)>0)
            {
                $drivers=Driver::where('group_id',$id)->get();
                $list=[];
                for($v=0;$v<count($drivers);$v++)
                {
                    $list[$v]=$drivers[$v]->id;
                }

                $contracts = Contract::select(['id', 'contract_number'])
                ->whereIn('id_driver',$list)
                ->with(['contract_data' => function ($query) {
                    return $query->orderBy('id', 'desc')->get();
                }])->get();
            return view('contract.showContracts', compact('contracts','id'));

            }
        }

        else if(Auth::guard('admin')->user()->hasPermission('contract_manage'))
        {
            $contracts = Contract::select(['id', 'contract_number'])
            ->with(['contract_data' => function ($query) {
                return $query->orderBy('id', 'desc')->get();
            }])
            ->get();

        return view('contract.showContracts', compact('contracts','id'));

        }
        return back();



    }
    public function view_contract(Request $request)
    {
        $request->validate([
            "driver_id" => 'required|string',
            "vechile_id" => 'required|string',
            "lease_term" => 'required|string',
            "lease_cost_dar_hour" => 'required|string',
            "lease_hours_delay_allowed" => 'required|string',
            "car_receipt_odometer_reading_at_exit" => 'required|string',
            "leasing_policy_return_car_before_contract_expire" => 'required|string',
            "leasing_policy_contract_extension" => 'required|string',
            "car_technical_condition_at_lease_air_condition" => 'required|string',
            "car_technical_condition_at_lease_radio_recorder" => 'required|string',
            "car_technical_condition_at_lease_dvr" => 'required|string',
            "car_technical_condition_at_lease_interior_screen" => 'required|string',
            "car_technical_condition_at_lease_speedometer" => 'required|string',
            "car_technical_condition_at_lease_interior_upholstery" => 'required|string',
            "car_technical_condition_at_lease_spare_cover_equipment" => 'required|string',
            "car_technical_condition_at_lease_wheel" => 'required|string',
            "car_technical_condition_at_lease_spare_wheel" => 'required|string',
            "car_technical_condition_at_lease_first_aid_kit" => 'required|string',
            "car_technical_condition_at_lease_oil_change_time" => 'required|string',
            "car_technical_condition_at_lease_key" => 'required|string',
            "car_technical_condition_at_lease_fire_extinguisher_availability" => 'required|string',
            "car_technical_condition_at_lease_availability_triangle_refactor" => 'required|string',
            "car_technical_condition_at_lease_printer" => 'required|string',
            "car_technical_condition_at_lease_point_sale_device" => 'required|string',
            "car_technical_condition_at_lease_fornt_screen" => 'required|string',
            "car_technical_condition_at_lease_internal_camera" => 'required|string',
            "car_technical_condition_at_lease_4sensor_seat" => 'required|string',
            "car_technical_condition_at_lease_button_emergency" => 'required|string',
            "car_technical_condition_at_lease_device_tracking" => 'required|string',
            "car_technical_condition_at_lease_light_taxi_mark" => 'required|string',
            "main_financial_vat" => 'required|string',
            "main_financial_cost_travelling_out_city" => 'required|string',
        ]);
        $driver = \App\Models\Driver::select([
            "id",
            "name",
            "nationality",
            "ssd",
            "address",
            "id_copy_no",
            "id_expiration_date",
            "license_type",
            "id_type",
            "place_issue",
            "license_number",
            "license_expiration_date",
            "birth_date",
            "start_working_date",
            "contract_end_date",
            "final_clearance_date",
            "phone",
        ])->find($request->driver_id);
        if ($driver === null) {
            $request->session()->flash('error', 'حدث خطاء فى بيانات السأئق، الرجاء المحاولة لاحقا');
            return back();
        }

        if ($driver->id == null || $driver->name == null || $driver->nationality == null || $driver->ssd == null || $driver->address == null || $driver->id_copy_no == null || $driver->id_expiration_date == null || $driver->license_type == null || $driver->id_type == null || $driver->place_issue == null || $driver->license_number == null || $driver->license_expiration_date == null || $driver->birth_date == null || $driver->start_working_date == null || $driver->contract_end_date == null || $driver->final_clearance_date == null || $driver->phone == null) {
            $request->session()->flash('error', 'الرجاء التأكد من أستكمال بيانات السأئق');
            return back();
        }

        $vechile = \App\Models\Vechile::select([
            'id',
            'vechile_type',
            'made_in',
            'serial_number',
            'plate_number',
            'color',
            'registration_type',
            'operation_card_number',
            'fuel_type',
            'amount_fuel',
            'insurance_policy_number',
            'insurance_type',
            'driving_license_expiration_date',
            'insurance_card_expiration_date',
            'periodic_examination_expiration_date',
            'operating_card_expiry_date',
        ])->find($request->vechile_id);
        if ($vechile === null) {
            $request->session()->flash('error', 'حدث خطاء فى بيانات المركبة، الرجاء المحاولة لاحقا');
            return back();
        }

        if ($vechile->id == null || $vechile->vechile_type == null || $vechile->made_in == null || $vechile->serial_number == null || $vechile->plate_number == null || $vechile->color == null || $vechile->registration_type == null || $vechile->operation_card_number == null || $vechile->fuel_type == null || $vechile->amount_fuel == null || $vechile->insurance_policy_number == null || $vechile->insurance_type == null || $vechile->driving_license_expiration_date == null || $vechile->insurance_card_expiration_date == null || $vechile->periodic_examination_expiration_date == null || $vechile->operating_card_expiry_date == null) {
            $request->session()->flash('error', 'الرجاء التأكد من أستكمال بيانات المركبة');
            return back();
        }

        $company = \App\Models\Nathiraat\Stakeholders::find(8);
        if ($company === null) {
            $request->session()->flash('error', 'حدث خطاء فى بيانات الشركة، الرجاء المحاولة لاحقا');
            return back();
        }

        return view('contract.viewContract', compact('driver', 'vechile', 'company', 'request'));

    }
}
