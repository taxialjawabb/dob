<?php

namespace App\Http\Controllers\Admin\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function get_stakeholders(Request $request)
    {
        $request->validate([

            'to' => 'required|string|in:driver,vechile,rider,stakeholder,user',
        ]);

        if ($request->to === 'driver') {
            $data = \App\Models\Driver::select(['id', 'name'])->get();
            return response()->json($data);
        } else if ($request->to === 'vechile') {
            $data = \App\Models\Vechile::select(['id', 'plate_number as name as name'])->get();
            return response()->json($data);
        } else if ($request->to === 'rider') {
            $data = \App\Models\Rider::select(['id', 'name'])->get();
            return response()->json($data);
        } else if ($request->to === 'user') {

            $data = \App\Models\Admin::select(['id', 'name'])->get();
            return response()->json($data);
        } else if ($request->to === 'stakeholder') {
            $data = \App\Models\Nathiraat\Stakeholders::select(['id', 'name'])->get();
            return response()->json($data);
        }

    }
}
