<?php

namespace App\Http\Controllers\Admin\Driver\Maintenance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Maintenance\Maintenance;
use App\Models\Driver;
use App\Models\Vechile;

class MaintenanceController extends Controller
{
    public function show()
    {
        $data = DB::select("select count(notes_driver.driver_id) as notes , driver.id as driverId , driver.name, driver.phone from driver left join notes_driver on  driver.id = notes_driver.driver_id group by notes_driver.driver_id order by notes desc;");
        // return $data;
        return view('driver.driverRecord.driverRecord', ['data' => $data]);
    }

    public function current_maintenance($id)
    {
        $driver = Driver::find($id);

        if($driver !== null){
            $data = Maintenance::select([
                'id',
        'maintenance_type',
        'counter_number',
        'counter_photo',
        'bill_photo',
        'added_date',
        'maintenance_note'
            ])->where( 'vechile_id', $driver->current_vechile)->where('driver_id', $driver->id)->get();

        return view('driver.driverRecord.driverMaintenance', ['data' => $data, 'id' => $id]);
        }
        else{
            return back();
        }
    }
    public function vechile_show_maintenance($id)
    {
        $vechile = Vechile::find($id);

        if($vechile !== null){
            $data = Maintenance::select([
                'id',
        'maintenance_type',
        'counter_number',
        'counter_photo',
        'bill_photo',
        'added_date',
        'maintenance_note'
            ])->where('vechile_id', $vechile->id)->get();

        return view('vechile.maintenance.showMaintenance', ['data' => $data]);
        }
        else{
            return back();
        }
    }
}
