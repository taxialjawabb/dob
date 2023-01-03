<?php

namespace App\Http\Controllers\Admin\Vechile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SecondaryCategory;
use App\Models\Vechile;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Vechile\VechileNotes;
use Illuminate\Support\Facades\Auth;

class VechileController extends Controller
{
    public function show_add()
    {
        $cat= Category::select('id', 'category_name')->get();
        if(count($cat) > 0){
            return view('vechile.vechiles.addVechile', compact('cat'));
        }else{
            return redirect('vechile/show/cagegory');
        }
    }
    public function secondary_category(Request $request)
    {
        $cat = Category::find($request->id);
        $data = $cat->secondary;

        return response()->json($data);
    }
    public function show_reports()
    {
       
        $data = Vechile::select(['vechile_type','state' ,'serial_number', 'plate_number', 'operating_card_expiry_date',
        'insurance_card_expiration_date','periodic_examination_expiration_date'])->get();
        return view('vechile.vechiles.showReportsView', compact('data'));
    }
    public function add_vechile(Request $request)
    {
        $request->validate([
            "stakeholder" => ['required','string'],
            'vechile_type' => ['required','string'],
            'made_in' => ['required','string'],
            'serial_number' => ['required','string'],
            'plate_number' => ['required','string'],
            'color' => ['required','string'],
            'driving_license_expiration_date' => ['required','date'],
            'insurance_card_expiration_date' => ['required','date'],
            'periodic_examination_expiration_date' => ['required','date'],
            'operating_card_expiry_date' => ['required','date'],
            // 'add_date' => [],
            // 'state' => [],
            // 'admin_id' => [],
            'category_id' => ['required','integer'],
            'secondary_id' => ['required','integer'],
            'daily_revenue_cost' => ['required', 'numeric'],
            'maintenance_revenue_cost' => ['required', 'numeric'],
            'identity_revenue_cost' => ['required', 'numeric'],
            'registration_type' => ['required', 'string'],
            'operation_card_number' => ['required', 'string'],
            'fuel_type' => ['required', 'string'],
            'amount_fuel' => ['required', 'string'],
            'insurance_policy_number' => ['required', 'string'],
            'insurance_type' => ['required', 'string'],
        ]);


        $vec = Vechile::where('plate_number', $request->plate_number)->
        orWhere('serial_number', $request->serial_number)->get();

        if(count($vec) > 0){
            $request->session()->flash('error', 'الرجاء التأكد من رقم اللوحة او رقم التسلسلى');
            return back();
        }
        else{
            $vechile= new Vechile;
            $vechile->vechile_type = $request-> vechile_type;
            $vechile->made_in = $request-> made_in;
            $vechile->serial_number = $request-> serial_number;
            $vechile->plate_number = $request-> plate_number;
            $vechile->color = $request-> color;
            $vechile->driving_license_expiration_date = $request-> driving_license_expiration_date;
            $vechile->insurance_card_expiration_date = $request-> insurance_card_expiration_date;
            $vechile->periodic_examination_expiration_date = $request-> periodic_examination_expiration_date;
            $vechile->operating_card_expiry_date = $request-> operating_card_expiry_date;
            $vechile->add_date = Carbon::now();
            $vechile->state = 'waiting';
            $vechile->admin_id =  Auth::guard('admin')->user()->id;
            if($request->stakeholder != 0 && $request->stakeholder != null){
                if($request->stakeholder !== 1){
                    $group = \App\Models\Groups\Group::find($request->stakeholder);

                    if($group->vechile_counter > $group->added_vechile){
                        $group->added_vechile++;
                        $group->save();
                    }else{
                        $request->session()->flash('error', 'لا يمكنك أضافة مركبات فى هذه المجموع مكتملة');
                        return back();
                    }
                }
                $vechile->group_id = $request->stakeholder;
            }
            $vechile->category_id = $request-> category_id;
            $vechile->secondary_id = $request-> secondary_id;
            $vechile->daily_revenue_cost = $request->daily_revenue_cost;
            $vechile->maintenance_revenue_cost = $request->maintenance_revenue_cost;
            $vechile->identity_revenue_cost = $request->identity_revenue_cost;
            $vechile->registration_type = $request->registration_type;
            $vechile->operation_card_number = $request->operation_card_number;
            $vechile->fuel_type = $request->fuel_type;
            $vechile->amount_fuel = $request->amount_fuel;
            $vechile->insurance_policy_number = $request->insurance_policy_number;
            $vechile->insurance_type = $request->insurance_type;

            $vechile->save();
            $request->session()->flash('status', 'تم إضافة المركبة بنجاح');
            return back();
        }
    }

    public function show_vechile($state = null)
    {
        $vechiles ;
        $title = 'عرض بيانات المركبات';
        if($state === 'active' || $state === 'waiting' || $state === 'blocked'){
            $vechiles = DB::select('select  vechile.id, vechile_type, made_in, plate_number, vechile.add_date, driver.name, driver.phone, admins.name as admin_name
                                    from vechile left join driver on vechile.id = driver.current_vechile left join admins on vechile.admin_id = admins.id where vechile.state = ?;',[$state]);
            $title = 'عرض بيانات المركبات ال'.$this->vechileState($state);
        }
        else{
            $vechiles = DB::select('select  vechile.id, vechile_type, made_in, plate_number, vechile.add_date, driver.name, driver.phone, admins.name as admin_name
                                    from vechile left join driver on vechile.id = driver.current_vechile left join admins on vechile.admin_id = admins.id;');
        }

        return view('vechile.vechiles.showVechile', compact('vechiles', 'title'));
    }

    public function detials($id)
    {
        $vechile = DB::select(' select
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
                                driver.name,
                                driver.phone,
                                admins.name as admin_name,
                                category.category_name,
                                secondary_category.name
                                from vechile left join category on vechile.category_id = category.id
                                left join driver on vechile.id = driver.current_vechile
                                left join admins on vechile.admin_id = admins.id
                                left join secondary_category on vechile.secondary_id = secondary_category.id  where vechile.id = ? limit 1;', [$id]);
        $vechile = $vechile[0];
        return view('vechile.vechiles.detials', compact('vechile'));
    }
    public function update_show($id)
    {
        $vechile = Vechile::find($id);
        if($vechile !== null){
            $cat= Category::select('id', 'category_name')->get();
            $secondary = SecondaryCategory::find($vechile->secondary_id);

            return view('vechile.vechiles.updateVechile', compact('vechile','cat', 'secondary'));
        }else{
            return redirect('vechile/show');
        }
    }
    public function update_vechile(Request $request)
    {
        // return $request->all();

        $request->validate([
            'id' => ['required','integer'],
            'vechile_type' => ['required','string'],
            'made_in' => ['required','string'],
            'serial_number' => ['required','string'],
            'plate_number' => ['required','string'],
            'color' => ['required','string'],
            'driving_license_expiration_date' => ['required','date'],
            'insurance_card_expiration_date' => ['required','date'],
            'periodic_examination_expiration_date' => ['required','date'],
            'operating_card_expiry_date' => ['required','date'],
            'category_id' => ['required','integer'],
            'secondary_id' => ['required','integer'],
            'daily_revenue_cost' => ['required', 'numeric'],
            'maintenance_revenue_cost' => ['required', 'numeric'],
            'identity_revenue_cost' => ['required', 'numeric'],
            'registration_type' => ['required', 'string'],
            'operation_card_number' => ['required', 'string'],
            'fuel_type' => ['required', 'string'],
            'amount_fuel' => ['required', 'string'],
            'insurance_policy_number' => ['required', 'string'],
            'insurance_type' => ['required', 'string'],

        ]);
        $vechile = Vechile::find($request->id);


        if($vechile !== null){
            $vec = DB::select('select id from vechile where id != ? and (serial_number= ? or plate_number = ? )', [$request->id,$request->serial_number, $request->plate_number]);
            if(count($vec) > 0){
                $request->session()->flash('error', 'الرجاء التأكد من رقم اللوحة او رقم التسلسلى');
                return back();
            }
            $note='';
            if($vechile->vechile_type!=$request->vechile_type)
            {
                 $note.=' تم تغيير نوع السيارة من '.($vechile->vechile_type==null?' فارغ ':$vechile->vechile_type).'  الي '.$request->vechile_type;



            }
            $vechile->vechile_type = $request-> vechile_type;
            if($vechile->made_in!=$request->made_in)
            {
                 $note.=' تم تغيير  سنة الصنع من '.($vechile->made_in==null?' فارغ ':$vechile->made_in).'  الي '.$request->made_in;



            }
            $vechile->made_in = $request-> made_in;

            if($vechile->serial_number!=$request->serial_number)
            {
                 $note.=' تم تغيير  رقم المسلسل من '.($vechile->serial_number==null?' فارغ ':$vechile->serial_number).'  الي '.$request->serial_number;



            }
            $vechile->serial_number = $request-> serial_number;
            if($vechile->plate_number!=$request->plate_number)
            {
                 $note.=' تم تغيير  رقم اللوحة من '.($vechile->plate_number==null?' فارغ ':$vechile->plate_number).'  الي '.$request->plate_number;


            }
            $vechile->plate_number = $request-> plate_number;
            if($vechile->color!=$request->color)
            {
                 $note.=' تم تغيير لون السيارة من '.($vechile->color==null?' فارغ ':$vechile->color).'  الي '.$request->color;



            }
            $vechile->color = $request-> color;
            if(date('Y-m-d', strtotime($vechile->driving_license_expiration_date))!=date('Y-m-d', strtotime($request->driving_license_expiration_date)))
            {
                $note.=' تم تغيير تاريخ انتهاء رخصة السيارة من '.($vechile->driving_license_expiration_date==null?' فارغ ':$vechile->driving_license_expiration_date).' الي '.$request->driving_license_expiration_date;



            }

            $vechile->driving_license_expiration_date = $request-> driving_license_expiration_date;

            if(date('Y-m-d', strtotime($vechile->insurance_card_expiration_date))!=date('Y-m-d', strtotime($request->insurance_card_expiration_date)))
            {
                $note.=' تم تغيير تاريخ إنتهاء التأمين من '.($vechile->insurance_card_expiration_date==null?' فارغ ':$vechile->insurance_card_expiration_date).' الي '.$request->insurance_card_expiration_date;



            }

            $vechile->insurance_card_expiration_date = $request-> insurance_card_expiration_date;
            if(date('Y-m-d', strtotime($vechile->periodic_examination_expiration_date))!=date('Y-m-d', strtotime($request->periodic_examination_expiration_date)))
            {
                $note.=' تم تغيير تاريخ إنتهاء الفحص الدورى من '.($vechile->periodic_examination_expiration_date==null?' فارغ ':$vechile->periodic_examination_expiration_date).' الي '.$request->periodic_examination_expiration_date;



            }

            $vechile->periodic_examination_expiration_date = $request-> periodic_examination_expiration_date;
            if(date('Y-m-d', strtotime($vechile->operating_card_expiry_date))!=date('Y-m-d', strtotime($request->operating_card_expiry_date)))
            {
                $note.=' تم تغيير تاريخ إنتهاء بطاقة التشغيل من '.($vechile->operating_card_expiry_date==null?' فارغ ':$vechile->operating_card_expiry_date).' الي '.$request->operating_card_expiry_date;



            }
            $vechile->operating_card_expiry_date = $request-> operating_card_expiry_date;
            if($vechile->category_id!=$request->category_id)
            {
                  $cat_vechile= Category::find($vechile->category_id);
                  $cat_request= Category::find($request->category_id);
                 if($cat_request!=null&&$cat_vechile!=null)
                 {
                    $note.=' تم تغيير نوع التصنيف من '.($vechile->category_id==null?' فارغ ': $cat_vechile->category_name).'  الي '.$cat_request->category_name;

                 }



            }
            $vechile->category_id = $request-> category_id;
            if($vechile->secondary_id!=$request->secondary_id)
            {


                $secondary_v = SecondaryCategory::find($vechile->secondary_id);
                $secondary_r = SecondaryCategory::find($request->secondary_id);
                if($secondary_v!=null&&$secondary_r!=null)
                {
                    $note.=' تم تغيير نوع التصنيف الفرعي من '.($vechile->secondary_id==null?' فارغ ':$secondary_v->name).'  الي '.$secondary_r->name;

                }



            }
            $vechile->secondary_id = $request-> secondary_id;
            if($vechile->daily_revenue_cost!=$request->daily_revenue_cost)
            {
                 $note.=' تم تغيير قيمةالعائد اليومي السيارة من '.($vechile->daily_revenue_cost==null?' فارغ ':$vechile->daily_revenue_cost).'  الي '.$request->daily_revenue_cost;



            }
            $vechile->daily_revenue_cost = $request->daily_revenue_cost;
            if($vechile->maintenance_revenue_cost!=$request->maintenance_revenue_cost)
            {
                 $note.=' تم تغيير  تكلفة العائد اليومي للصيانة من '.($vechile->maintenance_revenue_cost==null?' فارغ ':$vechile->maintenance_revenue_cost).'  الي '.$request->maintenance_revenue_cost;



            }
            $vechile->maintenance_revenue_cost = $request->maintenance_revenue_cost;
            if($vechile->identity_revenue_cost!=$request->identity_revenue_cost)
            {
                 $note.=' تم تغيير تكلفة العائد اليومي للأقامة من '.($vechile->identity_revenue_cost==null?' فارغ ':$vechile->identity_revenue_cost).'  الي '.$request->identity_revenue_cost;



            }
            $vechile->identity_revenue_cost = $request->identity_revenue_cost;
            if($vechile->registration_type!=$request->registration_type)
            {
                 $note.=' تم تغيير نوع الرخصة من '.($vechile->registration_type==null?' فارغ ':$vechile->registration_type).'  الي '.$request->registration_type;



            }
            $vechile->registration_type = $request->registration_type;
            if($vechile->operation_card_number!=$request->operation_card_number)
            {
                 $note.=' تم تغيير رقم بطاقة التشغيل  من '.($vechile->operation_card_number==null?' فارغ ':$vechile->operation_card_number).'  الي '.$request->operation_card_number;



            }
            $vechile->operation_card_number = $request->operation_card_number;
            if($vechile->fuel_type!=$request->fuel_type)
            {
                 $note.=' تم تغيير نوع الوقود   من '.($vechile->fuel_type==null?' فارغ ':$vechile->fuel_type).'  الي '.$request->fuel_type;



            }
            $vechile->fuel_type = $request->fuel_type;
            if($vechile->amount_fuel!=$request->amount_fuel)
            {
                 $note.=' تم تغيير  كمية الوقود من '.($vechile->amount_fuel==null?' فارغ ':$vechile->amount_fuel).'  الي '.$request->amount_fuel;



            }
            $vechile->amount_fuel = $request->amount_fuel;
            if($vechile->insurance_policy_number!=$request->insurance_policy_number)
            {
                 $note.=' تم تغيير رقم وثيقة التأمين  من '.($vechile->insurance_policy_number==null?' فارغ ':$vechile->insurance_policy_number).'  الي '.$request->insurance_policy_number;



            }
            $vechile->insurance_policy_number = $request->insurance_policy_number;
            if($vechile->insurance_type!=$request->insurance_type)
            {
                 $note.=' تم تغيير نوع التأمين من '.($vechile->insurance_type==null?' فارغ ':$vechile->insurance_type).'  الي '.$request->insurance_type;



            }
            $vechile->insurance_type = $request->insurance_type;
            if($note!=null)
            {
                $not = new VechileNotes;
                $not->note_type ="تعديل بيانات";
                $not->content = $note;
                $not->add_date = Carbon::now();
                $not->admin_id = Auth::guard('admin')->user()->id;
                $not->vechile_id = $vechile->id;
                $not->save();

            }
            $vechile->save();
            $request->session()->flash('status', 'تم تعديل بيانات المركبة بنجاح');
            return back();
        }else{
            $request->session()->flash('error', 'خطاء فى البيانات المدخلة');
            return back();
        }
    }

    public function drivers($id)
    {
        $drivers = DB::select(' select driver.name, driver.phone, driver.nationality, start_date_drive, end_date_drive, reason
        from vechile, driver, driver_vechile where vechile.id= driver_vechile.vechile_id and driver.id=driver_vechile.driver_id and vechile.id =?;', [$id]);
        return view('vechile.vechiles.driversForVechile', compact('drivers'));
    }

    public function show_state($id)
    {
        return view('vechile.vechiles.stateVechile', compact('id'));

    }
    public function save_state(Request $request){
        $vechile = Vechile::find($request->id);
        if($vechile !== null){
            $note = new VechileNotes;
            $note->vechile_id = $request->id;
            $note->admin_id =  Auth::guard('admin')->user()->id;
            $note->add_date = Carbon::now();
            $note->note_type = ' تغير حالة المركبة من ' . $this->getState($vechile->state) . '  الى  ' . $this->getState($request->state);
            $vechile->state = $request->state;
            $note->content = $request->reason;
            $vechile->save();
            $note->save();
            $request->session()->flash('status', 'تم تغير حالة المركبة بنجاح');

            return redirect('vechile/details/'.$request->id);
        }
        else{
            $request->session()->flash('error', 'حدث خطاء ما فى تغير حالة المركبة');

            return redirect('vechile/show');
        }

    }
    public function getState($state)
    {
        if($state=='active')
           return 'مستلم';
        else if($state=='blocked')
           return 'مستبعد'   ;
        else if($state=='waiting')
           return 'انتظار'   ;
        else if($state=='pending')
           return 'انتظار الموافقة'   ;
        else
           return ''   ;
    }


}
