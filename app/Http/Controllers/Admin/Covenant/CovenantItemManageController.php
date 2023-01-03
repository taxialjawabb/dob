<?php

namespace App\Http\Controllers\Admin\Covenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Models\Covenant\Covenant;
use  App\Models\Covenant\CovenantItem;
use  App\Models\Covenant\CovenantNotes;
use App\Models\Covenant\CovenantRecord;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CovenantItemManageController extends Controller
{
    public function show_add($id)
    {
        $covenants = Covenant::select(['covenant_name'])->where('id', $id)->get();
        return view('covenant.addItemCovenant', compact('covenants'));

    }
    public function show($covenant)
    {
        $covenants = DB::select("select covenant_items.id, covenant_items.serial_number, covenant_items.state, admins.name as admin_name,
        covenant_items.add_date, driver.name as driver_name, covenant_items.delivery_date
        from covenant_items left join admins on covenant_items.add_by = admins.id left join driver on covenant_items.current_driver = driver.id where  covenant_items.covenant_name =? ;	", [$covenant]);
        return view('covenant.showItemCovenant', compact('covenants'));
    }
    public function save_add(Request $request)
    {

        $request->validate([
            'covenant_name'=>'required|string',
            'counter'=>'required|integer'
        ]);
            $dataItems = $request->serial;
            $repeated = 0;

            if(count($dataItems) > 0){
                $convent=Covenant::where('covenant_name',$request->covenant_name)->where('delivered_user','!=',null)->first();

                $prevUserReceive =  CovenantRecord::where('forign_type', 'user')
                    ->where('receive_date', null)->orderBy('delivery_date', 'desc')->get();
                $adminDelivery = count($prevUserReceive) > 0 ? $prevUserReceive[0] : null;

                for ($i=0; $i < count($dataItems); $i++) {
                    $data = CovenantItem::where('covenant_name', $request->covenant_name)->where('serial_number',$dataItems[$i])->whereNotNull('serial_number')->limit(1)->get();
                    if(count($data) ===0){
                        $covenantItem = new CovenantItem;
                        $covenantItem->covenant_name = $request->covenant_name;
                        $covenantItem->add_by = Auth::guard('admin')->user()->id;
                        $covenantItem->add_date = Carbon::now();
                        $covenantItem->state = 'waiting';
                        $covenantItem->serial_number = $dataItems[$i];
                        $covenantItem->save();
                        if($adminDelivery !== null && $convent!=null){
                            $covenantRecord  = new  CovenantRecord;
                            $covenantRecord->forign_type = 'user';
                            $covenantRecord->forign_id = $adminDelivery->forign_id;
                            $covenantRecord->item_id = $covenantItem->id;
                            $covenantRecord->delivery_date = Carbon::now();
                            $covenantRecord->delivery_by =Auth::guard('admin')->user()->id;
                            $covenantRecord->save();
                        }
                    }else{
                        $repeated++;
                    }
                }
            $request->session()->flash('status', ' تم أضافة العهد بنجاح عدد العناصر المضافة ' .count($dataItems) - $repeated . ' تم تجاهل عدد ' .$repeated .' للتكرار');
            return back();
        }
        else{
            $request->session()->flash('error', 'خطاء ');
            return back();
        }
    }

    public function show_note($id)
    {
        $item = CovenantItem::find($id);
        if($item !== null){
            $notes = DB::select("
                                select 'driver' as convenant_type, covenant_notes.id, covenant_notes.record_id, covenant_notes.note_state,
                                covenant_notes.subject, covenant_notes.description,
                                covenant_notes.add_date,  admins.name as added_by, driver.name as covenant_by
                                from covenant_notes , admins , driver , covenant_record
                                where covenant_notes.add_by = admins.id and   covenant_notes.record_id = covenant_record.id
                                and covenant_record.forign_type ='driver' and  covenant_record.forign_id = driver.id and covenant_record.item_id = ?
                                union all
                                select 'user' as convenant_type, covenant_notes.id, covenant_notes.record_id, covenant_notes.note_state, covenant_notes.subject, covenant_notes.description,
                                covenant_notes.add_date,  ad1.name as added_by, ad2.name as covenant_by
                                from covenant_notes , admins ad1, admins ad2 , covenant_record
                                where covenant_notes.add_by = ad1.id and  covenant_notes.record_id = covenant_record.id
                                and covenant_record.forign_type ='user' and  covenant_record.forign_id = ad2.id and covenant_record.item_id = ?;
            ", [$id, $id]);
            return View('covenant.showNotesCovenant', compact('notes' , 'id'));
        }
        else{
            return back();
        }
    }
    public function add_note($id)
    {
        $item = CovenantItem::find($id);
        if($item !== null){
            return View('covenant.noteCovenant', compact('id'));
        }
        else{
            return back();
        }
    }
    public function save_note(Request $request)
    {
        $request->validate([
            'item_id'=>'required|integer',
            'state'=>'required|string|in:broken,waiting,active,damage,repair,theft',
            'subject'=>'required|string',
            'content'=>'required|string',
        ]);
        // return $request->all();
        $item = CovenantItem::find($request->item_id);
        $prevUserReceive =  CovenantRecord::where('item_id', $request->item_id)
                                        ->where('receive_by', null)
                                        ->where('receive_date', null)
                                        ->orderBy('delivery_date', 'desc')->get();
        $record = count($prevUserReceive) > 0 ? $prevUserReceive[0] : null;

        if($item !== null && $record !== null){
            $note = new CovenantNotes();
            $note->record_id = $record->id;
            $note->note_state = $request->state;
            $note->subject = $request->subject;
            $note->description = $request->content;
            $note->add_date = Carbon::now();
            $note->add_by = Auth::guard('admin')->user()->id;
            if($request->state === 'broken' || $request->state === 'damage' ||$request->state === 'theft'){
                $item->state = 'broken';
                $item->save();
            }
            else if($request->state === 'active' || $request->state === 'repair' ){
                $item->state = 'active';
                $item->save();
            }
            else if($request->state === 'waiting'){
                $item->state = 'waiting';
                $item->save();
            }
            $note->save();
            return redirect('covenant/show/note/'.$request->item_id);
        }
        else if($record === null){
            $request->session()->flash('error', 'الرجاء التأكد انه هذه العهد فى عهدة سائق او مستخدم');
            return back();
        }
        else{
            return back();
        }
    }

    public function show_record($id)
    {
        $data = DB::select("
                            select covenant_record.id,  forign_type, delivery_date , receive_date, admin_deliverd.name deliverd_name, admin_recieved.name  receive_by
                            from covenant_record
                            left join admins admin_deliverd  on  forign_id = admin_deliverd.id
                            left join admins admin_recieved on covenant_record.receive_by = admin_recieved.id where forign_type = 'user'and item_id = ?
                            union all
                            select covenant_record.id, forign_type, delivery_date , receive_date, driver_deliverd.name deliverd_name, admin_recieved.name  receive_by
                            from covenant_record
                            left join driver driver_deliverd  on  forign_id = driver_deliverd.id
                            left join admins admin_recieved on covenant_record.receive_by = admin_recieved.id where forign_type = 'driver' and item_id = ?;
        ", [$id , $id]);
        return View('covenant.showCovenantItemRecord', compact('data'));
    }
}
