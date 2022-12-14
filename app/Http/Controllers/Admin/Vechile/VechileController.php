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
            $request->session()->flash('error', '???????????? ???????????? ???? ?????? ???????????? ???? ?????? ????????????????');
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
                        $request->session()->flash('error', '???? ?????????? ?????????? ???????????? ???? ?????? ?????????????? ????????????');
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
            $request->session()->flash('status', '???? ?????????? ?????????????? ??????????');
            return back();
        }
    }

    public function show_vechile($state = null)
    {
        $vechiles ;
        $title = '?????? ???????????? ????????????????';
        if($state === 'active' || $state === 'waiting' || $state === 'blocked'){
            $vechiles = DB::select('select  vechile.id, vechile_type, made_in, plate_number, vechile.add_date, driver.name, driver.phone, admins.name as admin_name
                                    from vechile left join driver on vechile.id = driver.current_vechile left join admins on vechile.admin_id = admins.id where vechile.state = ?;',[$state]);
            $title = '?????? ???????????? ???????????????? ????'.$this->vechileState($state);
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
                $request->session()->flash('error', '???????????? ???????????? ???? ?????? ???????????? ???? ?????? ????????????????');
                return back();
            }
            $note='';
            if($vechile->vechile_type!=$request->vechile_type)
            {
                 $note.=' ???? ?????????? ?????? ?????????????? ???? '.($vechile->vechile_type==null?' ???????? ':$vechile->vechile_type).'  ?????? '.$request->vechile_type;



            }
            $vechile->vechile_type = $request-> vechile_type;
            if($vechile->made_in!=$request->made_in)
            {
                 $note.=' ???? ??????????  ?????? ?????????? ???? '.($vechile->made_in==null?' ???????? ':$vechile->made_in).'  ?????? '.$request->made_in;



            }
            $vechile->made_in = $request-> made_in;

            if($vechile->serial_number!=$request->serial_number)
            {
                 $note.=' ???? ??????????  ?????? ?????????????? ???? '.($vechile->serial_number==null?' ???????? ':$vechile->serial_number).'  ?????? '.$request->serial_number;



            }
            $vechile->serial_number = $request-> serial_number;
            if($vechile->plate_number!=$request->plate_number)
            {
                 $note.=' ???? ??????????  ?????? ???????????? ???? '.($vechile->plate_number==null?' ???????? ':$vechile->plate_number).'  ?????? '.$request->plate_number;


            }
            $vechile->plate_number = $request-> plate_number;
            if($vechile->color!=$request->color)
            {
                 $note.=' ???? ?????????? ?????? ?????????????? ???? '.($vechile->color==null?' ???????? ':$vechile->color).'  ?????? '.$request->color;



            }
            $vechile->color = $request-> color;
            if(date('Y-m-d', strtotime($vechile->driving_license_expiration_date))!=date('Y-m-d', strtotime($request->driving_license_expiration_date)))
            {
                $note.=' ???? ?????????? ?????????? ???????????? ???????? ?????????????? ???? '.($vechile->driving_license_expiration_date==null?' ???????? ':$vechile->driving_license_expiration_date).' ?????? '.$request->driving_license_expiration_date;



            }

            $vechile->driving_license_expiration_date = $request-> driving_license_expiration_date;

            if(date('Y-m-d', strtotime($vechile->insurance_card_expiration_date))!=date('Y-m-d', strtotime($request->insurance_card_expiration_date)))
            {
                $note.=' ???? ?????????? ?????????? ???????????? ?????????????? ???? '.($vechile->insurance_card_expiration_date==null?' ???????? ':$vechile->insurance_card_expiration_date).' ?????? '.$request->insurance_card_expiration_date;



            }

            $vechile->insurance_card_expiration_date = $request-> insurance_card_expiration_date;
            if(date('Y-m-d', strtotime($vechile->periodic_examination_expiration_date))!=date('Y-m-d', strtotime($request->periodic_examination_expiration_date)))
            {
                $note.=' ???? ?????????? ?????????? ???????????? ?????????? ???????????? ???? '.($vechile->periodic_examination_expiration_date==null?' ???????? ':$vechile->periodic_examination_expiration_date).' ?????? '.$request->periodic_examination_expiration_date;



            }

            $vechile->periodic_examination_expiration_date = $request-> periodic_examination_expiration_date;
            if(date('Y-m-d', strtotime($vechile->operating_card_expiry_date))!=date('Y-m-d', strtotime($request->operating_card_expiry_date)))
            {
                $note.=' ???? ?????????? ?????????? ???????????? ?????????? ?????????????? ???? '.($vechile->operating_card_expiry_date==null?' ???????? ':$vechile->operating_card_expiry_date).' ?????? '.$request->operating_card_expiry_date;



            }
            $vechile->operating_card_expiry_date = $request-> operating_card_expiry_date;
            if($vechile->category_id!=$request->category_id)
            {
                  $cat_vechile= Category::find($vechile->category_id);
                  $cat_request= Category::find($request->category_id);
                 if($cat_request!=null&&$cat_vechile!=null)
                 {
                    $note.=' ???? ?????????? ?????? ?????????????? ???? '.($vechile->category_id==null?' ???????? ': $cat_vechile->category_name).'  ?????? '.$cat_request->category_name;

                 }



            }
            $vechile->category_id = $request-> category_id;
            if($vechile->secondary_id!=$request->secondary_id)
            {


                $secondary_v = SecondaryCategory::find($vechile->secondary_id);
                $secondary_r = SecondaryCategory::find($request->secondary_id);
                if($secondary_v!=null&&$secondary_r!=null)
                {
                    $note.=' ???? ?????????? ?????? ?????????????? ???????????? ???? '.($vechile->secondary_id==null?' ???????? ':$secondary_v->name).'  ?????? '.$secondary_r->name;

                }



            }
            $vechile->secondary_id = $request-> secondary_id;
            if($vechile->daily_revenue_cost!=$request->daily_revenue_cost)
            {
                 $note.=' ???? ?????????? ???????????????????? ???????????? ?????????????? ???? '.($vechile->daily_revenue_cost==null?' ???????? ':$vechile->daily_revenue_cost).'  ?????? '.$request->daily_revenue_cost;



            }
            $vechile->daily_revenue_cost = $request->daily_revenue_cost;
            if($vechile->maintenance_revenue_cost!=$request->maintenance_revenue_cost)
            {
                 $note.=' ???? ??????????  ?????????? ???????????? ???????????? ?????????????? ???? '.($vechile->maintenance_revenue_cost==null?' ???????? ':$vechile->maintenance_revenue_cost).'  ?????? '.$request->maintenance_revenue_cost;



            }
            $vechile->maintenance_revenue_cost = $request->maintenance_revenue_cost;
            if($vechile->identity_revenue_cost!=$request->identity_revenue_cost)
            {
                 $note.=' ???? ?????????? ?????????? ???????????? ???????????? ?????????????? ???? '.($vechile->identity_revenue_cost==null?' ???????? ':$vechile->identity_revenue_cost).'  ?????? '.$request->identity_revenue_cost;



            }
            $vechile->identity_revenue_cost = $request->identity_revenue_cost;
            if($vechile->registration_type!=$request->registration_type)
            {
                 $note.=' ???? ?????????? ?????? ???????????? ???? '.($vechile->registration_type==null?' ???????? ':$vechile->registration_type).'  ?????? '.$request->registration_type;



            }
            $vechile->registration_type = $request->registration_type;
            if($vechile->operation_card_number!=$request->operation_card_number)
            {
                 $note.=' ???? ?????????? ?????? ?????????? ??????????????  ???? '.($vechile->operation_card_number==null?' ???????? ':$vechile->operation_card_number).'  ?????? '.$request->operation_card_number;



            }
            $vechile->operation_card_number = $request->operation_card_number;
            if($vechile->fuel_type!=$request->fuel_type)
            {
                 $note.=' ???? ?????????? ?????? ????????????   ???? '.($vechile->fuel_type==null?' ???????? ':$vechile->fuel_type).'  ?????? '.$request->fuel_type;



            }
            $vechile->fuel_type = $request->fuel_type;
            if($vechile->amount_fuel!=$request->amount_fuel)
            {
                 $note.=' ???? ??????????  ???????? ???????????? ???? '.($vechile->amount_fuel==null?' ???????? ':$vechile->amount_fuel).'  ?????? '.$request->amount_fuel;



            }
            $vechile->amount_fuel = $request->amount_fuel;
            if($vechile->insurance_policy_number!=$request->insurance_policy_number)
            {
                 $note.=' ???? ?????????? ?????? ?????????? ??????????????  ???? '.($vechile->insurance_policy_number==null?' ???????? ':$vechile->insurance_policy_number).'  ?????? '.$request->insurance_policy_number;



            }
            $vechile->insurance_policy_number = $request->insurance_policy_number;
            if($vechile->insurance_type!=$request->insurance_type)
            {
                 $note.=' ???? ?????????? ?????? ?????????????? ???? '.($vechile->insurance_type==null?' ???????? ':$vechile->insurance_type).'  ?????? '.$request->insurance_type;



            }
            $vechile->insurance_type = $request->insurance_type;
            if($note!=null)
            {
                $not = new VechileNotes;
                $not->note_type ="?????????? ????????????";
                $not->content = $note;
                $not->add_date = Carbon::now();
                $not->admin_id = Auth::guard('admin')->user()->id;
                $not->vechile_id = $vechile->id;
                $not->save();

            }
            $vechile->save();
            $request->session()->flash('status', '???? ?????????? ???????????? ?????????????? ??????????');
            return back();
        }else{
            $request->session()->flash('error', '???????? ???? ???????????????? ??????????????');
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
            $note->note_type = ' ???????? ???????? ?????????????? ???? ' . $this->getState($vechile->state) . '  ??????  ' . $this->getState($request->state);
            $vechile->state = $request->state;
            $note->content = $request->reason;
            $vechile->save();
            $note->save();
            $request->session()->flash('status', '???? ???????? ???????? ?????????????? ??????????');

            return redirect('vechile/details/'.$request->id);
        }
        else{
            $request->session()->flash('error', '?????? ???????? ???? ???? ???????? ???????? ??????????????');

            return redirect('vechile/show');
        }

    }
    public function getState($state)
    {
        if($state=='active')
           return '??????????';
        else if($state=='blocked')
           return '????????????'   ;
        else if($state=='waiting')
           return '????????????'   ;
        else if($state=='pending')
           return '???????????? ????????????????'   ;
        else
           return ''   ;
    }


}
