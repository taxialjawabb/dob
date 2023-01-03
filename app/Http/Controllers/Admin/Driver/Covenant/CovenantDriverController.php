<?php

namespace App\Http\Controllers\Admin\Driver\Covenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use  App\Models\Covenant\CovenantItem;
use Carbon\Carbon;
use App\Models\Covenant\CovenantRecord;
use Illuminate\Support\Facades\Auth;

class CovenantDriverController extends Controller
{
    public function delivery_covenant($id)
    {
        $driver = Driver::find($id);
        if($driver !== null){
            $covenants = DB::select('select covenant_items.id, covenant_items.covenant_name,
            covenant_items.serial_number, covenant_items.state , covenant_items.delivery_date
            from covenant_items where current_driver = ?', [$id]);
            $covRecord=CovenantRecord::select(['item_id'])
            ->where('forign_type','user')
            ->where('forign_id',Auth::guard('admin')->user()->id)
            ->where('receive_by',null)->get();

            $answers = [];
            foreach($covRecord as $item)
            {
                $answers[] = [$item->item_id];
            }

            $allCovenant=DB::table('covenant_items')
            ->selectRaw('id,count(id) as counts,covenant_name')
            ->groupBy('covenant_name')
            ->whereIn('id',$answers)
            ->get();

            return view('driver.covenant.showCovenant',compact('covenants', 'id', 'allCovenant'));
        }else{
            return back();
        }

    }

    public function show_add($id)
    {
        return view('driver.covenant.updateCovenant');
    }

    public function save_add(Request $request)
    {
        $request->validate([
            'id'=>'required|integer',
            'covenant_name'=>'required|string',
            'covenant_item'=>'required|string'
        ]);
        $userCovenants =  CovenantRecord::where('forign_type', 'user')->where('item_id', $request->covenant_item)
        ->where('receive_by', null)->where('receive_date', null)->orderBy('delivery_date', 'desc')->get();

        if(count($userCovenants) == 0){
            $request->session()->flash('error', 'خطاء لا يوجد مستخدم مستلم العهد  ');
            return back();
        }
        else if($userCovenants[0]->forign_id !== Auth::guard('admin')->user()->id){
            $request->session()->flash('error', 'يجب ان يكون مستخدم مستلم العهدة هو من يقوم بتسليم العهد ');
            return back();
        }
        $covenantItem = CovenantItem::find($request->covenant_item);
        if($covenantItem !== null){
            $prevUserReceive =  CovenantRecord::where('item_id', $request->covenant_item)
                                        ->where('forign_type', 'user')
                                        ->where('receive_date', null)
                                        ->orderBy('delivery_date', 'desc')->get();
            $adminDelivery = count($prevUserReceive) > 0 ? $prevUserReceive[0] : null;
            if($adminDelivery !== null){
                $adminDelivery->receive_date = Carbon::now();
                $adminDelivery->receive_by = Auth::guard('admin')->user()->id;
                $adminDelivery->save();
            }
            $covenantItem->current_driver = $request->id ;
            $covenantItem-> state = 'active' ;
            $covenantItem-> delivery_date = Carbon::now();

            $covenantRecord  = new CovenantRecord;
            $covenantRecord->forign_type = 'driver';
            $covenantRecord->forign_id = $request->id;
            $covenantRecord->item_id = $request->covenant_item;
            $covenantRecord->delivery_date = Carbon::now();
            $covenantRecord->delivery_by = Auth::guard('admin')->user()->id;

            $covenantItem->save();
            $covenantRecord->save();

            $request->session()->flash('status', 'تم تسليم العهد للسائق  نجاح');
        }
        else{
            $request->session()->flash('error', 'خطاء ');
        }
        return back();
    }
    public function show_item(Request $request)
    {
        $items =   CovenantItem::where('covenant_name', $request->id)
                                ->where(function($query){
                                    $query->where('state', 'waiting')
                                        ->orWhere('state', null);
                                        })->get();

        // $items =   DB::select("select id, serial_number from covenant_items where covenant_name = ? and (state = 'waiting' or state is null ); ", [$request->id]);
        return response()->json($items);


    }
}
