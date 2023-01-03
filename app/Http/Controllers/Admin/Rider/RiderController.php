<?php

namespace App\Http\Controllers\Admin\Rider;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Rider;
use App\Models\Trip;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use DataTables;
use App\DataTables\RiderDataTable;

class RiderController extends Controller
{
    public function __construct(){
       // $this->middleware(['role:super_user']);
    }
    public function index()
    {
        $riders = Rider::all();
        return view('rider.showRider', compact('riders'));
    }

    public function show(Request $request)
    {
        $rider = Rider::find($request->id);
        $trips = DB::select('select trips.id, driver.name, vechile.plate_number,trips.state, trips.trip_type ,trips.reqest_time
        from trips  left join rider on trips.rider_id = rider.id
        left join driver on trips.driver_id = driver.id
        left join vechile on vechile.id= driver.current_vechile where rider.id = ?;', [$request->id]);
        return view('rider.ridertrips', compact('trips', 'rider'));
        // return datatables($trips)->make(true);
    }

    public function edit(Request $request)
    {
        $rider = Rider::find($request->id);
        if($rider !== null){
            return view('rider.edit', compact('rider'));
        }else{
            return redirect('rider/show');
        }
    }
    public function change_state(Request $request)
    {
        // enum('active','blocked')
        $rider = Rider::find($request->id);
        if($rider->state === 'active'){
            $rider->state = 'blocked';
            $rider->save();
        }
        else if($rider->state === 'blocked'){
            $rider->state = 'active';
            $rider->save();
        }
        return back();
    }

    public function detials($id){
        $rider = Rider::find($id);
        if($rider !== null){
            return view('rider.detials', compact('rider'));
        }
        else{
            return redirect('rider');
        }
    }

    public function save_edit(Rider $rider, Request $request)
    {
        $request->validate([
            'address' =>  'required|string'
        ]);
        $rider->address = $request->address;
        $rider->save();
        $request->session()->flash('status', 'تم تعديل بيانات العميل بنجاح');
        return back();
    }
}
