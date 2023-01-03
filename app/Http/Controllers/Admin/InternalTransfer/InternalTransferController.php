<?php

namespace App\Http\Controllers\Admin\InternalTransfer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InternalTransferController extends Controller
{
    public function get_stakeholders(Request $request)
    {
        $request->validate([
            'from' =>'required|string|in:driver,vechile,rider,stakeholder,user',
            'to' => 'required|string|in:driver,vechile,rider,stakeholder,user',
            'id' => 'required|numeric'
        ]);

        if($request->from == $request->to){
            if($request->to === 'driver'){
                $data = \App\Models\Driver::select(['id' , 'name'])->where('id', '!=', $request->id)->get();
                return response()->json($data);
            }
            else if($request->to === 'vechile'){
                $data = \App\Models\Vechile::select(['id' , 'plate_number as name'])->where('id', '!=', $request->id)->get();
                return response()->json($data);
            }
            else if($request->to === 'rider'){
                $data = \App\Models\Rider::select(['id' , 'name'])->where('id', '!=', $request->id)->get();
                return response()->json($data);
            }
            else if($request->to === 'user'){

            $data = \App\Models\Admin::select(['id' , 'name'])->where('id', '!=', $request->id)->get();
            return response()->json($data);
            }
            else if($request->to === 'stakeholder'){
                $data = \App\Models\Nathiraat\Stakeholders::select(['id' , 'name'])->where('id', '!=', $request->id)->get();
                return response()->json($data);
            }
        }else{
            if($request->to === 'driver'){
                $data = \App\Models\Driver::select(['id' , 'name'])->get();
                return response()->json($data);
            }
            else if($request->to === 'vechile'){
                $data = \App\Models\Vechile::select(['id' , 'plate_number as name as name'])->get();
                return response()->json($data);
            }
            else if($request->to === 'rider'){
                $data = \App\Models\Rider::select(['id' , 'name'])->get();
                return response()->json($data);
            }
            else if($request->to === 'user'){

            $data = \App\Models\Admin::select(['id' , 'name'])->get();
            return response()->json($data);
            }
            else if($request->to === 'stakeholder'){
                $data = \App\Models\Nathiraat\Stakeholders::select(['id' , 'name'])->get();
                return response()->json($data);
            }
        }
        return $request->all();
    }
}
