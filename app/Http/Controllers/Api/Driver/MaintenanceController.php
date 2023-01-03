<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Maintenance\Maintenance;
use Carbon\Carbon;
use App\Models\Driver;
use App\Traits\GeneralTrait;
use App\Models\Driver\DriverNotes;

class MaintenanceController extends Controller
{
    use GeneralTrait;

    public function add_maintenance(Request $request)
    {
        $request->validate([
            'maintenance_type' => 'required|string',
            'counter_number' => 'required',
            'counter_photo' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'bill_photo' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'vechile_id' => 'required',
            'driver_id' => 'required',
        ]);
        $data = Maintenance::where('driver_id', $request->driver_id)->where('vechile_id', $request->vechile_id)
        ->orderBy('added_date', 'desc')->get();
        $driver = Driver::find($request->driver_id);
        if($driver == null){
            return $this->returnError('100008',"حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
        if(count($data) === 0){
            $maintenance = new Maintenance();
            $maintenance->maintenance_type = $request->maintenance_type;
            $maintenance->counter_number = $request->counter_number;
            $maintenance->counter_photo = $this->save_image( $request->counter_photo, 'counter');
            $maintenance->bill_photo =$this->save_image( $request->bill_photo, 'bills');
            $maintenance->added_date = Carbon::now();
            $maintenance->maintenance_note = $request->maintenance_note;
            $maintenance->vechile_id = $request->vechile_id;
            $maintenance->driver_id = $request->driver_id;
            $maintenance->save();
            $data = (object)[
                'id'=> (string)$maintenance->id,
                'maintenance_type'=> $maintenance->maintenance_type,
                'counter_number'=> (string)$maintenance->counter_number,
                'counter_photo'=> $maintenance->counter_photo,
                'bill_photo'=> $maintenance->bill_photo,
                'added_date'=> $maintenance->added_date,
                'confirm_date'=>$maintenance->confirm_date,
            ];

            return $this->returnData($data,"تم حفظ بيانات الصيانة بنجاح");
        }
        else if( count($data) === 1){
            $maintenance = new Maintenance();
            $maintenance->maintenance_type = $request->maintenance_type;
            $maintenance->counter_number = $request->counter_number;
            $maintenance->counter_photo = $this->save_image( $request->counter_photo, 'counter');
            $maintenance->bill_photo = $this->save_image( $request->bill_photo, 'bills');
            $maintenance->added_date = Carbon::now();
            $maintenance->maintenance_note = $request->maintenance_note;
            $maintenance->vechile_id = $request->vechile_id;
            $maintenance->driver_id = $request->driver_id;
            $maintenance->save();
            $counterSub = $maintenance->counter_number - $data[0]->counter_number;
            if(($counterSub) > 5000){
                $note = new DriverNotes;
                $note->note_type ='تم تجاوز الحد المسموح لتغير الزيت' . $counterSub;
                $note->content = 'تم تجاوز الحد المسموح لتغير الزيت' . $counterSub . ' للمركبة رقم ' . $request->vechile_id;
                $note->add_date = Carbon::now();
                // $note->admin_id = Auth::guard('admin')->user()->id;
                $note->driver_id = $request->driver_id;
                $note->save();
                $this->push_notification($driver->remember_token, 'تحذير تم تجاوز الحد المسموح لك لتغير الزيت', $note->content, 'warning');
            }
            $data = (object)[
                'id'=> (string)$maintenance->id,
                'maintenance_type'=> $maintenance->maintenance_type,
                'counter_number'=> (string)$maintenance->counter_number,
                'counter_photo'=> $maintenance->counter_photo,
                'bill_photo'=> $maintenance->bill_photo,
                'added_date'=> $maintenance->added_date,
                'confirm_date'=>$maintenance->confirm_date,
            ];

            return $this->returnData($data,"تم حفظ بيانات الصيانة بنجاح");
        }
        else if( count($data) > 1){
            $maintenance = new Maintenance();
            $maintenance->maintenance_type = $request->maintenance_type;
            $maintenance->counter_number = $request->counter_number;
            $maintenance->counter_photo = $this->save_image( $request->counter_photo, 'counter');
            $maintenance->bill_photo = $this->save_image( $request->bill_photo, 'bills');
            $maintenance->added_date = Carbon::now();
            $maintenance->maintenance_note = $request->maintenance_note;
            $maintenance->vechile_id = $request->vechile_id;
            $maintenance->driver_id = $request->driver_id;
            $maintenance->save();
            $prefSub = $data[0]->counter_number - $data[1]->counter_number;
            $counterSub = $maintenance->counter_number - $data[0]->counter_number;
            $maxCounter = 10000 -$prefSub;
            $maxCounter = $maxCounter > 5000 ?  5000 : $maxCounter;
            if(($counterSub) > $maxCounter ){
                $note = new DriverNotes;
                $note->note_type ='تم تجاوز الحد المسموح لتغير الزيت' . $counterSub;
                $note->content = 'تم تجاوز الحد المسموح لتغير الزيت' . $counterSub . ' للمركبة رقم ' . $request->vechile_id . ' الحد المسموح لتغير الزيت ' . $maxCounter . ' لتجاوز المرة السابقة ايضا ب ' . $prefSub;
                $note->add_date = Carbon::now();
                // $note->admin_id = Auth::guard('admin')->user()->id;
                $note->driver_id = $request->driver_id;
                $note->save();
                $this->push_notification($driver->remember_token, 'تحذير تم تجاوز الحد المسموح لك لتغير الزيت', $note->content, 'warning');
            }
            $data = (object)[
                'id'=> (string)$maintenance->id,
                'maintenance_type'=> $maintenance->maintenance_type,
                'counter_number'=> (string)$maintenance->counter_number,
                'counter_photo'=> $maintenance->counter_photo,
                'bill_photo'=> $maintenance->bill_photo,
                'added_date'=> $maintenance->added_date,
                'confirm_date'=>$maintenance->confirm_date,
            ];

            return $this->returnData($data,"تم حفظ بيانات الصيانة بنجاح");
        }
        else{
            return $this->returnError('10'," .حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
    }

    private function save_image( $file, $source)
    {
            $name = $file->getClientOriginalName();
            $ext  = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $mim  = $file->getMimeType();
            $realpath = $file->getRealPath();
            $image = time().'.'.$ext;
            $path = 'images/drivers/maintenance/'.$source;
            $file->move(public_path($path),$image);
            return  $path.'/'.$image;
    }

    public function show_maintenance(Request $request)
    {
        $request->validate([
            'driver_id' => 'required',
        ]);
        $driver = Driver::find($request->driver_id);
        if($driver !== null){
            $data = Maintenance::select([ 'id', 'maintenance_type','counter_number' , 'counter_photo', 'bill_photo', 'added_date', 'maintenance_note', 'confirm_date'])
                        ->where('driver_id', $driver->id)->where('vechile_id', $driver->current_vechile)->paginate(10);

            return $this -> returnData($data, 'maintenance for this vechile');
        }
        else{
            return $this->returnError('100008'," .حدث خطاء الرجاء المحاولة فى وقت لاحق");
        }
    }
}
